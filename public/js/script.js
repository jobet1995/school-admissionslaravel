function initPage(isForm) {
    M.Dropdown.init(document.querySelectorAll('.dropdown'))
    M.FormSelect.init(document.querySelectorAll('select'))
    if (isForm) {
        setSearchParams()
        maskInput()
        let firstInput = document.querySelector('form input:not([type=hidden]):not([readonly]), form select:not([readonly])')
        if (firstInput) {
            firstInput.focus()
        }
    }
    else {
        searchChange()
    }
}

function maskInput() {
    let range = IMask.MaskedRange
    let maskType = {
        date: {
            mask: 'mm/dd/yyyy',
            blocks: {
                dd: { mask: range, from: 1, to: 31, placeholderChar: 'D' },
                mm: { mask: range, from: 1, to: 12, placeholderChar: 'M' },
                yyyy: { mask: range, from: 1, to: 9999, placeholderChar: 'Y' }
            }
        },
        time: {
            mask: 'HH:MM:ss',
            blocks: {
                HH: { mask: range, from: 0, to: 23, placeholderChar: 'H' },
                hh: { mask: range, from: 0, to: 12, placeholderChar: 'H' },
                MM: { mask: range, from: 0, to: 59, placeholderChar: 'M' },
                ss: { mask: range, from: 0, to: 59, placeholderChar: 'S' },
                TT: { mask: IMask.MaskedEnum, enum: [ 'am', 'pm', 'AM', 'PM' ], placeholderChar: 'T' }
            }
        },
        datetime: {}
    }
    maskType.datetime = {
        mask: maskType.date.mask + ' ' + maskType.time.mask,
        blocks: { ...maskType.date.blocks, ...maskType.time.blocks }
    }
    document.querySelectorAll('input[data-type]').forEach(e => { //https://github.com/uNmAnNeR/imaskjs/issues/98
        let type = e.getAttribute('data-type')
        let mask = IMask(e, maskType[type])
        e._imask = mask
        e.addEventListener('focus', () => { //https://github.com/uNmAnNeR/imaskjs/issues/152
            mask.updateValue()
            mask.updateOptions({ lazy: false })
        })
        e.addEventListener('blur', () => {
            mask.updateOptions({ lazy: true })
        })
    })
    let locale = {
        days: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
        daysShort: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
        daysMin: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
        months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        today: 'Today',
        clear: 'Clear',
        firstDay: 0
    }
    let dateFormat = {
        date: 'MM/DD/YYYY',
        time: 'HH:mm:ss',
        datetime: 'MM/DD/YYYY HH:mm:ss'
    }
    let pickerType = {
        date: {
            locale,
            dateFormat: (date) => {
                return moment(date).format(dateFormat.date)
            }
        },
        time: {
            locale,
            timepicker: true,
            onlyTimepicker: true,
            dateFormat: (date) => {
                return moment(date).format(dateFormat.time)
            }
        },
        datetime: {
            locale,
            timepicker: true,
            dateFormat: (date) => {
                return moment(date).format(dateFormat.datetime)
            }
        }
    }
    document.querySelectorAll('input[data-type]').forEach(e => {
        let type = e.getAttribute('data-type')
        let option = {...pickerType[type]}
        let picker = new AirDatepicker(e, option)
        e._airpicker = picker
        picker.opts.onShow = (isFinished) => {
            if (isFinished) {
                let date = moment(e.value, dateFormat[type])
                if (date.isValid()) {
                    picker.setViewDate(date)
                    picker.selectDate(date, { updateTime: true, silent: true })
                }
            }
        }
    })
}

function unmaskInput() {
    document.querySelectorAll('input[data-type]').forEach(e => {
        e._imask.destroy()
        e._airpicker.destroy()
    })
}

function setSearchParams() {
    if (location.pathname.toLowerCase().endsWith('create')) {
        new URLSearchParams(location.search).forEach((value, key) => {
            let element = document.getElementById(key) || document.getElementById(key + value)
            if (element) {
                if (element.type == 'radio') {
                    element.click()
                    document.querySelectorAll(`[id^="${key}"]`).forEach(e => {
                        e.parentElement.classList.add('readonly')
                    })
                }
                else {
                    element.value = value
                    element.setAttribute('readonly', '')
                    if (element.tagName == 'SELECT') {
                        M.FormSelect.init(element, { classes: 'readonly' })
                    }
                }
            }
        })
    }
}

function clearSearch() {
    document.getElementById('search_word').value = ''
    let index = location.search.indexOf('?sw=')
    if (index < 0) {
        index = location.search.indexOf('&sw=')
    }
    if (index >= 0) {
        let url = location.pathname + location.search.substr(0, index)
        location = url
    }
}

function search(e) {
    if (!e || e.keyCode == 13) {
        let searchWord = document.getElementById('search_word')
        let value = searchWord.value
        if (value) {
            let search = `sw=${value}&sc=${ document.getElementById('search_col').value}&so=${ document.getElementById('search_oper').value}`
            let query = (!location.search || location.search.substr(0, 4) == '?sw=' ? `?${search}` : `${location.search.split('&sw=')[0]}&${search}`)
            let matches = query.match(/page=\d+/)
            if (matches) {
                query = query.replace(matches[0], 'page=1')
            }
            let url = location.pathname + query
            location = url
        }
        else {
            searchWord.focus()
        }
    }
}

function searchChange() {
    let searchWord = document.getElementById('search_word')
    if (searchWord.getAttribute('data-type')) {
        unmaskInput()
        searchWord.outerHTML = searchWord.outerHTML.toString() //remove all mask/datepicker custom event listeners
        searchWord = document.getElementById('search_word')
    }
    let type = document.getElementById('search_col').selectedOptions[0].getAttribute('data-type') || 'text'
    if (type == 'date' || type == 'time' || type == 'datetime') {
        searchWord.setAttribute('type', 'text')
        searchWord.setAttribute('data-type', type)
        maskInput()
    }
    else {
        searchWord.setAttribute('type', type)
        searchWord.removeAttribute('data-type')
    }
    let searchOper = document.getElementById('search_oper')
    let disabled = (type != 'text')
    searchOper.options[0].disabled = disabled
    if (disabled && searchOper.selectedIndex == 0) {
        searchOper.selectedIndex = 1
    }
    if (document.activeElement.id == 'search_col') {
        searchWord.select()
    }
    M.FormSelect.init(searchOper) //https://github.com/Dogfalo/materialize/issues/4685
}

function deleteItem(e) {
    if (confirm('Delete this item?')) {
        e.parentNode.submit()
    }
}

function submitForm() { //fix nested form issue in some Edit View
    while (document.querySelector('form')) {
        document.querySelector('form').remove()
    }
    let div = document.querySelector('div[data-method]')
    let form = document.createElement('form')
    form.method = div.getAttribute('data-method')
    form.action = div.getAttribute('data-action')
    div.parentNode.prepend(form)
    form.append(div)
    form.submit()
}

function validateForm() {
    let password = document.querySelector('input[type=password]:not([data-match])')
    let match = document.querySelector('[data-match]')
    if (!password.value && (!match || !match.value)) { //do not change password
        return true
    }
    let passwordError = validatePassword(password.value)
    let isPasswordMatch = true
    if (match) {
        isPasswordMatch = document.getElementById(match.getAttribute('data-match')).value == match.value
    }
    if (passwordError) {
        alert(passwordError)
    }
    else if (!isPasswordMatch) {
        alert('Password do not match!')
    }
    let isFormValid = (!passwordError && isPasswordMatch)
    return isFormValid
}

function validatePassword(value) {
    let error = ''
    if (!/[a-z]/.test(value)) {
        error += 'Must include lowercase letter\n'
    }
    if (!/[A-Z]/.test(value)) {
        error += 'Must include uppercase letter\n'
    }
    if (!/[^A-Za-z0-9]/.test(value)) {
        error += 'Must include symbol\n'
    }
    if (!/[0-9]/.test(value)) {
        error += 'Must include number\n'
    }
    if (value.length < 6 || value.length > 10) {
        error += 'Must have length between 6 and 10'
    }
    if (error) {
        error = 'Password does not meet requirements:\n' + error
    }
    return error
}