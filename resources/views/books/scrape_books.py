import asyncio
import logging
import aiohttp
from bs4 import BeautifulSoup
import json
import sys

# Set up logging for debugging
logging.basicConfig(level=logging.DEBUG)
logger = logging.getLogger("zlibrary")

async def fetch_page(url, session):
    logger.debug(f"Fetching page: {url}")
    async with session.get(url) as response:
        page_content = await response.text()
        logger.debug(f"Page fetched successfully from: {url}")
        return page_content

async def post_login(session, email, password):
    login_url = 'https://singlelogin.re/?remix_userid=5245319&remix_userkey=50371d71512cf9e41a08fe52c05ef8bd'
    logger.debug(f"Logging in at: {login_url}")
    async with session.get(login_url) as response:
        logger.debug("Login successful")
        return response

async def parse_books_page(html, session):
    soup = BeautifulSoup(html, 'html.parser')
    
    # Find all book rows
    book_rows = soup.find_all('tr', class_='bookRow')
    logger.debug(f"Found {len(book_rows)} book rows")

    results = []
    for row in book_rows:
        book = {}
        
        # Title and link
        title_tag = row.find('a', style="text-decoration: underline;")
        if title_tag:
            book['title'] = title_tag.text.strip()
            book['url'] = 'https://singlelogin.re' + title_tag['href']
        
        # Authors
        authors_tag = row.find('div', class_='authors')
        if authors_tag:
            book['authors'] = ', '.join(author.text.strip() for author in authors_tag.find_all('a'))

        # Publisher
        publisher_tag = row.find('div', style="color: #333; font-size: 10pt;margin-bottom:10px;")
        if publisher_tag:
            book['publisher'] = publisher_tag.text.strip()

        # Extract additional details from the book detail page
        detail_html = await fetch_page(book['url'], session)
        if detail_html:
            book_details = await parse_book_details(detail_html)
            book.update(book_details)
        
        results.append(book)
    
    return results

async def parse_book_details(html):
    soup = BeautifulSoup(html, 'html.parser')
    
    book_details = {}
    
    # Extract raw <z-cover> HTML
    zcover_tag = soup.find('z-cover')
    if zcover_tag:
        book_details['zcover'] = str(zcover_tag)
        logger.debug(f"<z-cover> found: {book_details['zcover']}")

        # Extract the 'data-src' attribute from the <img> tag within <z-cover>
        img_tag = zcover_tag.find('img')
        if img_tag and img_tag.has_attr('data-src'):
            book_details['Image'] = img_tag['data-src']
            logger.debug(f"Image URL found: {book_details['Image']}")
    
    # Extract year, language, file, and rating
    properties = soup.find_all('div', class_='bookProperty')
    for prop in properties:
        label_div = prop.find('div', class_='property_label')
        value_div = prop.find('div', class_='property_value')
        
        if label_div and value_div:
            label = label_div.text.strip()
            value = value_div.text.strip()
            
            if label == 'Year:':
                book_details['year'] = value
            elif label == 'Language:':
                book_details['language'] = value
            elif label == 'File:':
                book_details['file'] = value
            elif label == 'Book Rating / File Quality':
                book_details['rating'] = value
    
    # Debugging statement for <a class="btn btn-primary dlButton">
    download_btn = soup.find('a', class_='btn btn-primary dlButton')
    if download_btn:
        book_details['Download Button'] = str(download_btn)
        logger.debug(f"Download button found: {book_details['Download Button']}")
    else:
        logger.debug("Download button not found!")

    return book_details

async def fetch_books_for_keywords(keywords, email, password):
    combined_results = []

    async with aiohttp.ClientSession() as session:
        # Log in
        await post_login(session, email, password)
        
        for keyword in keywords:
            search_url = f'https://singlelogin.re/s/{keyword.replace(" ", "%20")}?page=1'
            html = await fetch_page(search_url, session)
            results = await parse_books_page(html, session)
            combined_results.extend(results)

    return combined_results

async def main():
    # Replace with your zlibrary email and password
    email = "nzambakitheka@gmail.com"
    password = "6cp@Lydia"
    keywords = ['Dag Heward Mills']
    # keywords = ['Dag Heward Mills', 'C.S Lewis', 'Derek Prince', 'Christian']
    results = await fetch_books_for_keywords(keywords, email, password)
    
    # Output combined results in JSON format
    print(json.dumps(results, indent=2))

if __name__ == '__main__':
    asyncio.run(main())
