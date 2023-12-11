let newSectionCounter = 0;
const emptyStateElement = document.querySelector("#sections-empty-state");
const pageTitleElement = document.querySelector("#page-title");
const titleInputElement = document.querySelector("#title");
const sectionNameElement = document.querySelector("#sectionName");
const sectionsListElement = document.querySelector("ul#sections");
const sectionsArrayInputElement = document.querySelector("input#sectionsArray");
const goodForNameElement = document.querySelector("#goodForElement");
const goodForItemsElement = document.querySelector("#goodForItems");
const goodForItemsInputElement = document.querySelector("input[type=hidden][name=goodForItems]");

const updatePageTitle = () => {
    pageTitleElement.innerText = titleInputElement.value.trim();
}

const handleEmptyState = () => {
    let sectionsCount = emptyStateElement.parentElement.children.length - 1;
    if (sectionsCount > 0) {
        emptyStateElement.classList.add("d-none");
    }
    else {
        emptyStateElement.classList.remove("d-none");
    }
}

const addNewSectionToSectionsArrayInput = (sectionName) => {
    if (sectionsArrayInputElement.value === '') {
        sectionsArrayInputElement.value += sectionName;
    }
    else {
        sectionsArrayInputElement.value += `,${sectionName}`;
    }
}

const addNewSectionToSectionsList = () => {
    const newTaskElement = document.createElement("li");
    newTaskElement.classList.add("list-group-item");
    newTaskElement.innerHTML = `
    <div class='d-flex justify-content-between align-items-center'>
    ${sectionNameElement.value}
    <button type='button' class='btn btn-sm btn-outline-danger btn-w-icon' onclick='removeSectionFromSectionsList(this)'>
    <i class='fa fa-solid fa-trash me-1'></i>
    حذف
    </button>
    </div>
    `;

    // Adding new section to sections array input
    addNewSectionToSectionsArrayInput(sectionNameElement.value);

    sectionsListElement.appendChild(newTaskElement);
    sectionNameElement.value = '';
    sectionNameElement.focus();
}

const removeSectionFromSectionsList = (deleteButtonElement) => {
    const sectionElementWhichWeWantToRemove = deleteButtonElement.closest("li");
    sectionElementWhichWeWantToRemove.remove();
    const sectionName = deleteButtonElement.previousSibling.textContent.trim()
    removeSectionNameFromSectionsArrayInput(sectionName);
}

const removeSectionNameFromSectionsArrayInput = (sectionName) => {
    sectionsArrayInputElement.value = sectionsArrayInputElement.value.replace(sectionName, "").replace(/^,|,$/g, "").trim();
    // handle only having one section name (remove tailing comma)
    if (sectionsArrayInputElement.value.trim().charAt(0) === ',') {
        sectionsArrayInputElement.value.trim().replace(",", "")
    }
    // handle removing the last secion name
    if (sectionsArrayInputElement.value.trim().length <= 1) {
        sectionsArrayInputElement.value = '';
    }
}

const handlePressingEnterOnSectionNameElement = (event) => {
    if (event.key === 'Enter') {
        event.preventDefault();
        addNewSectionToSectionsList();
    }
}

const addNewItemToGoodForList = () => {
    const newGoodForElement = document.createElement("li");
    newGoodForElement.classList.add("mb-1", "list-group-item", "d-flex", "justify-content-between", "align-items-center");
    newGoodForElement.innerHTML = `
    <span>${goodForNameElement.value.trim()}</span>
    <button type="button" class="btn btn-sm btn-outline-danger btn-w-icon"
    onclick="removeItemFromGoodForList(this)">
        <i class="fa fa-solid fa-trash me-1"></i>
        حذف
    </button>
    `;
    goodForItemsElement.appendChild(newGoodForElement);
    goodForNameElement.value = "";
    saveAllGoodForTextsInTheHiddenField();
}

const removeItemFromGoodForList = (element) => {
    element.closest("li").remove();
    saveAllGoodForTextsInTheHiddenField();
}

const handlePressingEnterOnGoodForElement = (event) => {
    if (event.key === 'Enter') {
        event.preventDefault();
        addNewItemToGoodForList();
    }
}

const getAllGoodForTexts = () => {
    let itemsText = [];
    goodForItemsElement.querySelectorAll("li").forEach((item)=>{
        itemsText.push(item.children[0].innerText.trim());
    });
    return itemsText.toString();
}

const saveAllGoodForTextsInTheHiddenField = () => {
    goodForItemsInputElement.value = getAllGoodForTexts();
}

goodForNameElement.addEventListener('keypress', (event) => { handlePressingEnterOnGoodForElement(event) })