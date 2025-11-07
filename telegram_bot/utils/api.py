import requests
from config import API_URL

headers = {
    'Content-Type': 'application/json',
    'Accept': 'application/json'
}

def get_categories():
    return requests.get(API_URL + 'categories').json()['data']

def get_category(category_id: int):
    return requests.get(API_URL + 'categories/' + str(category_id)).json()['data']

def get_products():
    return requests.get(API_URL + 'products').json()['data']

def get_product(product_id: int):
    return requests.get(API_URL + 'products/' + str(product_id)).json()['data']

def add_product_to_cart(option_id: int, chat_id: int):
    payload = {
        "chat_id": chat_id,
        "product_id": option_id,
    }
    return requests.post(API_URL + 'cart_items', json=payload).json()['data']

def create_user(chat_id: int, username: str):
    data = {
        "chat_id": chat_id,
        "username": username
    }
    return requests.post(API_URL + 'users', headers=headers, json=data)

def get_cart(chat_id: int):
    return requests.get(API_URL + f"users/{chat_id}/cart").json()['data']

def get_cart_with_items(chat_id: int):
    return requests.get(
        API_URL + f"users/{chat_id}/cart",
        params="include=items"
    ).json()['data']

def destroy_cart(cart_id: int):
    return requests.delete(API_URL + f"carts/{cart_id}", headers=headers)

def delete_cart_item(item_id: int):
    return requests.patch(API_URL + f"cart_items/{item_id}", headers=headers)

def create_invoice(
    cart_id: int,
    first_name: str,
    last_name: str,
    middle_name: str,
    delivery_address: str,
    phone: str
):
    data={
        'cart_id': cart_id,
        'first_name': first_name,
        'last_name': last_name,
        'middle_name': middle_name,
        'delivery_address': delivery_address,
        'phone': phone 
    }
    return requests.post(API_URL + f'invoices', headers=headers, json=data)

def get_invoice(chat_id: int):
    return requests.get(API_URL + f"users/{chat_id}/invoice", headers=headers).json()['data']

def mark_invoice_as_paid(invoice_id: int):
    return requests.patch(API_URL + f"invoices/{invoice_id}/pay", headers=headers).json()

def get_paid_invoices():
    return requests.get(API_URL + f'invoices?filter[status]=paid', headers=headers).json()['data']

def mark_invoice_as_sent(invoice_id: int):
    return requests.patch(API_URL + f"invoices/{invoice_id}/send", headers=headers)

def create_product(data):
    return requests.post(API_URL + f'products', headers=headers, json=data)

def delete_product(product_id: int):
    return requests.delete(API_URL + f"products/{product_id}", headers=headers)

def get_cities(city: str):
    data = {
        'city': city
    }
    return requests.get(API_URL + f'invoices/get_cities', headers=headers, json=data).json()['data']

def get_visa(user_id: int):
    return requests.get(API_URL + f'users/{user_id}/visa', headers=headers)
    
def create_visa(data):
    return requests.post(API_URL + f'visas', headers=headers, json=data)

def extend_visa(visa_id: int):
    return requests.patch(API_URL + f"visas/{visa_id}", headers=headers)