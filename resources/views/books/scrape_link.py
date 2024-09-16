import asyncio
import aiohttp
import logging
from bs4 import BeautifulSoup
import json

# Set up logging
logging.basicConfig(level=logging.DEBUG)
logger = logging.getLogger("book_scraper")

# ZLibrary credentials
EMAIL = "nzambakitheka@gmail.com"
PASSWORD = "6cp@Lydia"

async def login(session):
    """Log in to ZLibrary and save the session cookies."""
    login_url = "https://singlelogin.re"
    payload = {
        "email": EMAIL,
        "password": PASSWORD
    }
    
    logger.debug(f"Logging in with email: {EMAIL}")
    async with session.post(login_url, data=payload) as response:
        if response.status == 200:
            logger.debug("Logged in successfully!")
            return True
        else:
            logger.error(f"Login failed with status: {response.status}")
            return False

async def fetch_page(url, session):
    """Fetch the content of a page."""
    logger.debug(f"Fetching page: {url}")
    async with session.get(url) as response:
        if response.status == 200:
            page_content = await response.text()
            logger.debug(f"Page fetched successfully from: {url}")
            return page_content
        else:
            logger.error(f"Failed to fetch page: {url} with status: {response.status}")
            return None

async def parse_book_page(html):
    """Parse the HTML of the book page to extract details."""
    soup = BeautifulSoup(html, 'html.parser')
    book_details = {}

    # Book Title
    title_tag = soup.find('h1', itemprop="name")
    if title_tag:
        book_details['title'] = title_tag.text.strip()
        logger.debug(f"Title: {book_details['title']}")

    # Author
    author_tag = soup.find('a', class_='color1')
    if author_tag:
        book_details['author'] = author_tag.text.strip()
        logger.debug(f"Author: {book_details['author']}")

    # Year, Publisher, Language, ISBN, File
    properties = soup.find_all('div', class_='bookProperty')
    for prop in properties:
        label = prop.find('div', class_='property_label')
        value = prop.find('div', class_='property_value')
        if label and value:
            label_text = label.text.strip()
            value_text = value.text.strip()

            if label_text == 'Year:':
                book_details['year'] = value_text
            elif label_text == 'Publisher:':
                book_details['publisher'] = value_text
            elif label_text == 'Language:':
                book_details['language'] = value_text
            elif label_text == 'ISBN 10:':
                book_details['isbn_10'] = value_text
            elif label_text == 'ISBN 13:':
                book_details['isbn_13'] = value_text
            elif label_text == 'File:':
                book_details['file'] = value_text
            logger.debug(f"{label_text} {value_text}")

    # Extract the download links and data-book_id
    actions_container = soup.find('section', class_='book-actions-container')
    if actions_container:
        details_buttons_container = actions_container.find('div', class_='details-buttons-container')
        if details_buttons_container:
            book_details['actions_html'] = {}

            # Extract data-book_id and href from the download button
            dl_button = details_buttons_container.find('a', class_='dlButton')
            if dl_button and dl_button.has_attr('href'):
                book_details['actions_html']['download_link'] = dl_button['href']
                book_details['actions_html']['data_book_id'] = dl_button['data-book_id']
                logger.debug(f"Download link: {dl_button['href']}, Data Book ID: {dl_button['data-book_id']}")
            else:
                logger.warning("Download button not found")

        else:
            logger.warning("details-buttons-container not found in book-actions-container")
    else:
        logger.warning("book-actions-container not found")

    return book_details

async def scrape_book_details(url, session):
    """Scrape book details from a given URL."""
    html = await fetch_page(url, session)
    if html:
        # Parse the page and extract book details
        book_details = await parse_book_page(html)
        return book_details

async def main():
    # The URL to scrape
    book_url = "https://singlelogin.re/book/2326677/2289cc/its-our-turn-to-eat.html"

    # Create a session and log in
    async with aiohttp.ClientSession() as session:
        logged_in = await login(session)
        
        if logged_in:
            # Scrape the book details
            book_details = await scrape_book_details(book_url, session)

            # Output the result as a JSON object
            print(json.dumps(book_details, indent=2))
        else:
            logger.error("Failed to log in. Exiting.")

if __name__ == '__main__':
    asyncio.run(main())
