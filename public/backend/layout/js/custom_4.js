const selected_5 = document.querySelector(".selected_5");
const optionsContainer_5 = document.querySelector(".options-container_5");

const optionsList_5 = document.querySelectorAll(".option_5");

selected_5.addEventListener("click", () => {
    optionsContainer_5.classList.toggle("active");
});

optionsList_5.forEach(o => {
    o.addEventListener("click", () => {
        o.querySelector('input').checked = true;
        selected_5.innerHTML = o.querySelector("label").innerHTML;
        optionsContainer_5.classList.remove("active");
    });
});