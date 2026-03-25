export function initProgressBar(barId) {
    const progressBar = document.getElementById(barId);
    if (!progressBar) return;

    window.addEventListener('scroll', () => {
        const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
        const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const scrolled = (winScroll / height) * 100;
        progressBar.style.width = scrolled + "%";
    });
}

export function openTopicFromUrl() {
    const params = new URLSearchParams(window.location.search);
    const topicId = params.get('topic_id');

    if (topicId) {
        const target = document.querySelector(`[data-topic-id="${topicId}"]`);
        const header = target?.querySelector('.topic-header');
        if (header) {
            toggleTopic(header);
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }
}

export function toggleTopic(header) {
    const topicItem = header.parentElement;
    if (topicItem) {
        topicItem.classList.toggle('open');
    }
}