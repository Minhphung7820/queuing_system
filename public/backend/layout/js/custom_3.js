const selected_4 = document.querySelector(".selected_4");
const optionsContainer_4 = document.querySelector(".options-container_4");

const optionsList_4 = document.querySelectorAll(".option_4");

selected_4.addEventListener("click", () => {
    optionsContainer_4.classList.toggle("active");
});

optionsList_4.forEach(o => {
    o.addEventListener("click", () => {
        o.querySelector('input').checked = true;
        selected_4.innerHTML = o.querySelector("label").innerHTML;
        optionsContainer_4.classList.remove("active");
    });
});