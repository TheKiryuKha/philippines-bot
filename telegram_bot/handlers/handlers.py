from aiogram import Dispatcher
from aiogram import F
from aiogram.filters import Command
from handlers.start import get_start
from handlers.shop import shop
from handlers.product import show, destroy as destroy_product
from handlers.cart import store, show as cart_show, destroy, edit
from handlers.cart_item import destroy as cart_item_destroy, store as cart_item_store
from handlers.none import none
from handlers.invoice import start_create, store as store_invoice, create_city, store_city, create_data
from state.StoreInvoiceState import StoreInvoiceState
from state.StoreProductState import StoreProductState
from handlers.invoice import pay, mark_paid, get_paid, mark_as_sent
from handlers.send import send
from handlers.save import create as save_create_products, store as save_store_products


# long work...

def register_handlers(dp: Dispatcher):
    dp.message.register(get_start, Command(commands='start'))
    dp.message.register(shop, Command(commands='shop'))
    dp.callback_query.register(shop, F.data =='shop')

    dp.callback_query.register(show, F.data.startswith('product_'))

    dp.callback_query.register(store, F.data.startswith('addToCart_'))

    dp.callback_query.register(cart_show, F.data == 'cart')
    dp.message.register(cart_show, Command(commands='cart'))

    dp.callback_query.register(destroy, F.data == 'clear_cart')

    dp.callback_query.register(edit, F.data == 'edit_cart')

    dp.callback_query.register(cart_item_destroy, F.data.startswith('decrease_cart:'))
    dp.callback_query.register(cart_item_store, F.data.startswith('increase_cart:'))
    
    
    dp.callback_query.register(none, F.data == 'none')

    dp.callback_query.register(create_data, F.data == 'start_create_invoice')
    dp.message.register(store_invoice, StoreInvoiceState.regData)

    dp.message.register(pay, StoreInvoiceState.waitingForPayment)
    dp.callback_query.register(mark_paid, F.data.startswith('mark_paid_invoice:'))

    dp.message.register(get_paid, Command(commands='to_ship'))
    dp.callback_query.register(mark_as_sent, F.data.startswith('mark_sent_invoice:'))

    dp.message.register(send, Command(commands='send'))

    dp.message.register(save_create_products, Command(commands='save'))
    dp.message.register(save_store_products, StoreProductState.regData)
    dp.callback_query.register(destroy_product, F.data.startswith('delete_'))