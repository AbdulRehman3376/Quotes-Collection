function validateForm() {
  const text = document.querySelector('[name="quote_text"]').value.trim();
  const author = document.querySelector('[name="author"]').value.trim();
  const category = document.querySelector('[name="category"]').value;

  if (text.length < 10 || text.length > 500) {
    alert("Quote must be 10 to 500 characters.");
    return false;
  }
  if (author.length < 3 || author.length > 50) {
    alert("Author must be 3 to 50 characters.");
    return false;
  }
  if (!category) {
    alert("Select a category.");
    return false;
  }
  return true;
}
