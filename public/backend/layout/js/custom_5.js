const selected_6 = document.querySelector(".selected_6");
const optionsContainer_6 = document.querySelector(".options-container_6");

const optionsList_6 = document.querySelectorAll(".option_6");

selected_6.addEventListener("click", () => {
    optionsContainer_6.classList.toggle("active");
});

optionsList_6.forEach(o => {
    o.addEventListener("click", () => {
        o.querySelector('input').checked = true;
        selected_6.innerHTML = o.querySelector("label").innerHTML;
        optionsContainer_6.classList.remove("active");
    });
});