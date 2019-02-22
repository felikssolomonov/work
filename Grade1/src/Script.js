function onClick(element) {
    id = element.id;
    document.location.href="index.php?selected=" + id;
    return element.id;
}