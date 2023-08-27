const messages = Array.from(document.getElementsByClassName("message-content"));

messages.forEach((item) => {
    item.innerText = item.innerText.trim();
});
