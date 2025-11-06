from aiogram.fsm.state import StatesGroup, State

class StoreInvoiceState(StatesGroup):
    # regCity = State()
    regData = State()
    waitingForPayment = State()