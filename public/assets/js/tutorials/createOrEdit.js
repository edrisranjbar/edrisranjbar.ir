let newSectionCounter = 0;
const emptyStateElement = document.querySelector("#sections-empty-state");

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

// Function to add a new section
const addNewSection = () => {
    const sectionTemplate = document.querySelector('#sectionTemplate');
    const newSection = document.importNode(sectionTemplate.content, true);
    newSection.id = `newSection${newSectionCounter}`;
    newSection.querySelectorAll('[name^="newSections"]').forEach(element => {
        element.name = 'newSections[]';
    });
    newSection.querySelector('.section-title').textContent = prompt("عنوان بخش جدید:");
    newSectionCounter++;

    // Attach the delete button functionality
    newSection.querySelector('.delete-section-btn').addEventListener('click', function () {
        this.closest('.form-check').remove();
    });

    document.querySelector('#sectionsGroup').appendChild(newSection);
}

const deleteSection = (element) => {
    element.closest('.form-check').remove();
    handleEmptyState();
}

// Attach the add new section button functionality
document.querySelector('#addSectionBtn').addEventListener('click', function () {
    addNewSection();
    handleEmptyState();
});