document.addEventListener("DOMContentLoaded", function() {
    // Get references to the radio buttons and the submit button
    const institutionalUserRadio = document.getElementById("institutionalUser");
    const individualUserRadio = document.getElementById("individualUser");
    const submitButton = document.querySelector(".button");

    // Add an event listener to the submit button
    submitButton.addEventListener("click", function(event) {
        // Prevent the default form submission
        event.preventDefault();

        // Check which radio button is selected
        if (institutionalUserRadio.checked) {
            // Redirect to the institutional page
            window.location.href = "inst_create.php";
        } else if (individualUserRadio.checked) {
            // Redirect to the individual user page
            window.location.href = "indi_create.php";
        }
    });
});
