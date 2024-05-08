export default function changeFormAction() {
    const button = document.getElementById("change-button");

    button.addEventListener('click', () => {
        document.getElementById("title").removeAttribute("readonly");
        document.getElementById("author").removeAttribute("readonly");
        document.getElementById("isbn").removeAttribute("readonly");
        button.style.display = "none";
        document.getElementById("save-button").style.display = "block";
    })
}