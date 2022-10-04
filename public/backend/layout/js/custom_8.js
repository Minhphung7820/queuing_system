const selected_9 = document.querySelector(".selected_9");
const optionsContainer_9 = document.querySelector(".options-container_9");

const optionsList_9 = document.querySelectorAll(".option_9");

selected_9.addEventListener("click", () => {
    optionsContainer_9.classList.toggle("active");
});

optionsList_9.forEach(o => {
    o.addEventListener("click", () => {
        o.querySelector('input').checked = true;
        selected_9.innerHTML = o.querySelector("label").innerHTML;
        optionsContainer_9.classList.remove("active");
    });
});