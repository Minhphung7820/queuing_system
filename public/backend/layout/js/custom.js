const selected = document.querySelector(".selected");
const optionsContainer = document.querySelector(".options-container");

const optionsList = document.querySelectorAll(".option");

selected.addEventListener("click", () => {
    optionsContainer.classList.toggle("active");
});

optionsList.forEach(o => {
    o.addEventListener("click", () => {
        o.querySelector('input').checked = true;
        selected.innerHTML = o.querySelector("label").innerHTML;
        optionsContainer.classList.remove("active");
    });
});



// ######################################################



const selected_2 = document.querySelector(".selected_2");
const optionsContainer_2 = document.querySelector(".options-container_2");

const optionsList_2 = document.querySelectorAll(".option_2");

selected_2.addEventListener("click", () => {
    optionsContainer_2.classList.toggle("active");
});

optionsList_2.forEach(o => {
    o.addEventListener("click", () => {
        o.querySelector('input').checked = true;
        selected_2.innerHTML = o.querySelector("label").innerHTML;
        optionsContainer_2.classList.remove("active");
    });
});


// #########################################################