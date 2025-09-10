document.addEventListener('DOMContentLoaded', () => {
    const jobLink = document.querySelectorAll('.resumator-job-link');
    jobLink.forEach((item) => {
        item.classList.add('custom-button');
    });
});
