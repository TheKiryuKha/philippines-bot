from aiogram.fsm.state import StatesGroup, State

class StoreProductState(StatesGroup):
    regData = State()