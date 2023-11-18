let newSectionCounter = 0;
const emptyStateElement = document.querySelector("#sections-empty-state");
const pageTitleElement = document.querySelector("#page-title");
const titleInputElement = document.querySelector("#title");

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

    // Attach the add new lesson button functionality
    newSection.querySelector('.add-lesson-btn').addEventListener('click', function () {
        addNewLesson(this.closest('.section-container').querySelector('.lessons-group'));
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

const addNewLesson = (lessonsGroup) => {
    const lessonTemplate = document.querySelector('#lessonTemplate');
    const newLesson = document.importNode(lessonTemplate.content, true);
    lessonsGroup.appendChild(newLesson);
}

const deleteLesson = (element) => {
    element.closest('.lesson').remove();
}

// Attach the add new lesson button functionality for existing sections
document.querySelectorAll('.add-lesson-btn').forEach(button => {
    button.addEventListener('click', function () {
        addNewLesson(this.closest('.section-container').querySelector('.lessons-group'));
    });
});