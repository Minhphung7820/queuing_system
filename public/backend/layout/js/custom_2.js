const selected_3 = document.querySelector(".selected_3");
const optionsContainer_3 = document.querySelector(".options-container_3");

const optionsList_3 = document.querySelectorAll(".option_3");

selected_3.addEventListener("click", () => {
    optionsContainer_3.classList.toggle("active");
});

optionsList_3.forEach(o => {
    o.addEventListener("click", () => {
        o.querySelector('input').checked = true;
        selected_3.innerHTML = o.querySelector("label").innerHTML;
        optionsContainer_3.classList.remove("active");
    });
});

// ################################################################