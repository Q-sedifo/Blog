// Slider
let sliderItem = document.querySelector('.track div')
let amountItems = document.querySelectorAll('.track .slider-element').length
const track = document.querySelector('.slider .track')
const itemWidth = sliderItem.offsetWidth
const paginationItems = document.querySelectorAll('.slider-pagination div')
let position = 1

paginationItems[0].classList.add('active-position')

function moveSliderNext() {
    position++
    if (position > amountItems || position < 1) position = 1
    moveSlider()
    assignPosition(position)
}

function moveSliderPrev() {
    position--
    if (position > amountItems || position < 1) position = amountItems
    moveSlider()
    assignPosition(position)
}

function moveSlider() {
    track.style.transform = `translateX(${(-itemWidth * (position - 1))}px)`
}

function assignPosition(position = 0) {
    paginationItems.forEach(e => e.classList.remove('active-position'))
    paginationItems[position - 1].classList.add('active-position')
}







