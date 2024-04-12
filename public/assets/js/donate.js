const donateOptionButtons = document.querySelectorAll(".donate-options button:not([type=submit])");
const customAmountButton = document.querySelector("#custom-amount-btn");
const customAmountFieldInputField = document.querySelector("#custom-amount-field");

const showCustomAmountField = () => {
    customAmountFieldInputField.classList.remove("d-none");
}

const hideCustomAmountField = () => {
    customAmountFieldInputField.classList.add("d-none");
}

const toggleActiveButton = (button) => {
    if (button.id === null || button.id !== 'custom-amount-btn') hideCustomAmountField()
    donateOptionButtons.forEach((button) => button.classList.remove('active'));
    button.classList.add('active');
    customAmountFieldInputField.value = button.value;
}

donateOptionButtons.forEach((button) => button.addEventListener('click', () => { toggleActiveButton(button) }))
customAmountButton.addEventListener('click', () => {
    showCustomAmountField();
    customAmountFieldInputField.focus();
});