const selected_8 = document.querySelector(".selected_8");
const optionsContainer_8 = document.querySelector(".options-container_8");

const optionsList_8 = document.querySelectorAll(".option_8");

selected_8.addEventListener("click", () => {
    optionsContainer_8.classList.toggle("active");
});

optionsList_8.forEach(o => {
    o.addEventListener("click", () => {
        o.querySelector('input').checked = true;
        selected_8.innerHTML = o.querySelector("label").innerHTML;
        optionsContainer_8.classList.remove("active");
    });
});