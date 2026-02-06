<script>
    const searchData = {
        subjects: <?= json_encode($subjects) ?>,
        topics: <?= json_encode($topics) ?>,
        lessons: <?= json_encode($lessons) ?>,
        media: <?= json_encode($media) ?>
    };
    console.log(searchData)
</script>

<main class="search-page">
    <div class="search-container">
        <nav class="search-tabs">
            <button class="tab active" data-type="subjects">Курсы</button>
            <button class="tab" data-type="topics">Темы</button>
            <button class="tab" data-type="lessons">Уроки</button>
            <button class="tab" data-type="media">Медиа</button>
        </nav>

        <div class="search-results" id="results-container">       
            
        </div>
    </div>
</main>