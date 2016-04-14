export const ping = store => next => action => {
    console.log(`Тип события: ${action.type}, дополнительные данные события: ${action.payload}`)
    return next(action)
}
