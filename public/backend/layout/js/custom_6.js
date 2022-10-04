const selected_7 = document.querySelector(".selected_7");
const optionsContainer_7 = document.querySelector(".options-container_7");

const optionsList_7 = document.querySelectorAll(".option_7");

selected_7.addEventListener("click", () => {
    optionsContainer_7.classList.toggle("active");
});

optionsList_7.forEach(o => {
    o.addEventListener("click", () => {
        o.querySelector('input').checked = true;
        selected_7.innerHTML = o.querySelector("label").innerHTML;
        optionsContainer_7.classList.remove("active");
    });
});