const tutorialSelectElement = document.querySelector("#tutorial_id");
tutorialSelectElement.addEventListener('input', (event) => {
    const selectedItem = event.target.options[event.target.options.selectedIndex];
    const tutorialID = selectedItem.dataset.tutorialid;

    //todo: filter sections by tutorial id dataset!
    filterSectionsByTutorialID(tutorialID);
})

const filterSectionsByTutorialID = (tutorialID) => {
    document.querySelectorAll(`#section_id option`).forEach((option)=>option.classList.add("d-none"));
    document.querySelectorAll(`#section_id option[data-tutorialID='${tutorialID}']`).forEach((option)=>option.classList.remove("d-none"));
}