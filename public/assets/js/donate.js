const donateOptionButtons = document.querySelectorAll(".donate-options button:not([type=submit])");
const customAmountButton = document.querySelector("#custom-amount-btn");
const customAmountFieldInputField = document.querySelector("#custom-amount-field");
const shareButton = document.querySelector(".donate-share-button");

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
    customAmountFieldInputField.setAttribute('value', button.getAttribute('value'));
}

donateOptionButtons.forEach((button) => button.addEventListener('click', () => { toggleActiveButton(button) }))
customAmountButton.addEventListener('click', () => {
    showCustomAmountField();
    customAmountFieldInputField.focus();
});
shareButton.addEventListener('click', () => {
    navigator.clipboard.writeText(window.location.href);
    const toast = new bootstrap.Toast(document.getElementById('successToast'));
    toast.show();
})

const copyText = document.getElementById('copyText');
copyText.addEventListener('click', function () {
    navigator.clipboard.writeText(copyText.textContent)
    const CopyWalletToast = new bootstrap.Toast(document.getElementById('walletToast'));
    CopyWalletToast.show();
});