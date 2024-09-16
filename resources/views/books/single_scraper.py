import asyncio
import logging
import aiohttp
from bs4 import BeautifulSoup
import json
import re
import sys
import logging
import aiohttp

logger = logging.getLogger(__name__)

# Set up logging for debugging
logging.basicConfig(level=logging.DEBUG)
logger = logging.getLogger("zlibrary")

# ZLibrary credentials
EMAIL = "nzambakitheka@gmail.com"
PASSWORD = "6cp@Lydia"

# Limit the number of concurrent requests
MAX_CONCURRENT_REQUESTS = 10
semaphore = asyncio.Semaphore(MAX_CONCURRENT_REQUESTS)

async def fetch_page(url, session):
    async with semaphore:
        logger.debug(f"Fetching page: {url}")
        try:
            async with session.get(url) as response:
                if response.status == 200:
                    page_content = await response.text()
                    logger.debug(f"Page fetched successfully from: {url}")
                    return page_content
                else:
                    logger.error(f"Failed to fetch page: {url} with status: {response.status}")
                    return None
        except Exception as e:
            logger.error(f"Exception occurred: {e}")
            return None
    
async def post_login(session):
    login_url = 'https://singlelogin.re/?remix_userid=5245319&remix_userkey=50371d71512cf9e41a08fe52c05ef8bd'
    logger.debug(f"Logging in at: {login_url}")
    try:
        async with session.get(login_url) as response:
            if response.status == 200:
                logger.debug("Login successful")
                return True
            else:
                logger.error(f"Login failed with status: {response.status}")
                return False
    except Exception as e:
        logger.error(f"Exception occurred during login: {e}")
        return False

def extract_download_location(download_link):
    match = re.search(r'download_location=([^&]+)', download_link)
    if match:
        return match.group(1)
    return None

async def parse_books_page(html, session):
    soup = BeautifulSoup(html, 'html.parser')
    book_rows = soup.find_all('tr', class_='bookRow')
    logger.debug(f"Found {len(book_rows)} book rows")

    results = []
    tasks = [parse_book_row(row, session) for row in book_rows]
    results = await asyncio.gather(*tasks)
    return [book for sublist in results for book in sublist]

async def parse_book_row(row, session):
    book = {}
    
    title_tag = row.find('a', style="text-decoration: underline;")
    if title_tag:
        book['title'] = title_tag.text.strip()
        book['url'] = 'https://singlelogin.re' + title_tag['href']
    
    authors_tag = row.find('div', class_='authors')
    if authors_tag:
        book['authors'] = ', '.join(author.text.strip() for author in authors_tag.find_all('a'))

    publisher_tag = row.find('div', style="color: #333; font-size: 10pt;margin-bottom:10px;")
    if publisher_tag:
        book['publisher'] = publisher_tag.text.strip()

    detail_html = await fetch_page(book['url'], session)
    if detail_html:
        book_details = await parse_book_details(detail_html, session)
        book.update(book_details)
    
    return [book]

async def parse_book_details(html, session):
    soup = BeautifulSoup(html, 'html.parser')
    book_details = {}

    zcover_tag = soup.find('z-cover')
    if zcover_tag:
        img_tag = zcover_tag.find('img')
        if img_tag and img_tag.has_attr('data-src'):
            book_details['Image'] = img_tag['data-src']
            logger.debug(f"Image URL found: {book_details['Image']}")
    
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
    
    actions_container = soup.find('section', class_='book-actions-container')
    if actions_container:
        details_buttons_container = actions_container.find('div', class_='details-buttons-container')
        if details_buttons_container:
            book_details['actions_html'] = {}

            dl_button = details_buttons_container.find('a', class_='btn btn-primary dlButton addDownloadedBook reader-link')
            if dl_button and dl_button.has_attr('href'):
                download_link = dl_button['href']
                book_details['actions_html']['download_link'] = download_link
                book_details['actions_html']['data_book_id'] = dl_button['data-book_id']
                
                download_location = extract_download_location(download_link)
                if download_location:
                    book_details['actions_html']['Actual Download Link'] = download_location
                
                logger.debug(f"Download link: {download_link}, Data Book ID: {dl_button['data-book_id']}, Actual Download Link: {download_location}")
            else:
                logger.warning("Download button not found")

        else:
            logger.warning("details-buttons-container not found in book-actions-container")
    else:
        logger.warning("book-actions-container not found")

    return book_details

async def fetch_and_parse_books(keyword, session):
    search_url = f'https://singlelogin.re/s/{keyword.replace(" ", "%20")}?page=1'
    html = await fetch_page(search_url, session)
    return await parse_books_page(html, session)

async def main():
    keyword = sys.argv[1]
    results = []

    async with aiohttp.ClientSession() as session:
        logged_in = await post_login(session)
        if not logged_in:
            logger.error("Failed to log in. Exiting.")
            return results

        results = await fetch_and_parse_books(keyword, session)
    
    print(json.dumps(results, indent=2))

if __name__ == '__main__':
    asyncio.run(main())
