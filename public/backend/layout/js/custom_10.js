const selected_11 = document.querySelector(".selected_11");
const optionsContainer_11 = document.querySelector(".options-container_11");

const optionsList_11 = document.querySelectorAll(".option_11");

selected_11.addEventListener("click", () => {
    optionsContainer_11.classList.toggle("active");
});

optionsList_11.forEach(o => {
    o.addEventListener("click", () => {
        o.querySelector('input').checked = true;
        selected_11.innerHTML = o.querySelector("label").innerHTML;
        optionsContainer_11.classList.remove("active");
    });
});