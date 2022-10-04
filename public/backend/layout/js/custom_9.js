const selected_10 = document.querySelector(".selected_10");
const optionsContainer_10 = document.querySelector(".options-container_10");

const optionsList_10 = document.querySelectorAll(".option_10");

selected_10.addEventListener("click", () => {
    optionsContainer_10.classList.toggle("active");
});

optionsList_10.forEach(o => {
    o.addEventListener("click", () => {
        o.querySelector('input').checked = true;
        selected_10.innerHTML = o.querySelector("label").innerHTML;
        optionsContainer_10.classList.remove("active");
    });
});