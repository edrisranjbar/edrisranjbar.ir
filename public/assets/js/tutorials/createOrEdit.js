let newSectionCounter = 0;
const emptyStateElement = document.querySelector("#sections-empty-state");
const pageTitleElement = document.querySelector("#page-title");
const titleInputElement = document.querySelector("#title");
const sectionNameElement = document.querySelector("#sectionName");
const sectionsListElement = document.querySelector("ul#sections");

const updatePageTitle = () => {
    pageTitleElement.innerText = titleInputElement.value.trim();
}

const handleEmptyState = () => {
    let sectionsCount = emptyStateElement.parentElement.children.length - 1;
    if(sectionsCount > 0)
    {
        emptyStateElement.classList.add("d-none");
    }
    else{
        emptyStateElement.classList.remove("d-none");
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
    sectionsListElement.appendChild(newTaskElement);
}

const removeSectionFromSectionsList = (deleteButtonElement) => {
    const sectionElementWhichWeWantToRemove = deleteButtonElement.closest("li");
    sectionElementWhichWeWantToRemove.remove();
}