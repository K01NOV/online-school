<?php
    // Имитируем данные, которые якобы пришли из JSON
    $data = [
        'video_id' => 'u_S86_Nl_3E', // Пример обучающего видео про двоичную систему
        'audio_url' => '/assets/audio/binary_intro.mp3',
        'text_block_1' => 'Системы счисления — это способы записи чисел с помощью специальных знаков. Мы привыкли к десятичной системе, где используются цифры от 0 до 9. Однако компьютеры «общаются» на другом языке — двоичном. В нём всего две цифры: 0 и 1. Это связано с тем, что внутри процессора есть только два состояния: «сигнал есть» (1) и «сигнала нет» (0).',
        'image_url' => 'https://img.freepik.com/free-vector/binary-code-concept-illustration_114360-685.jpg', 
        'text_block_2' => 'Чтобы перевести число из десятичной системы в двоичную, нужно последовательно делить это число на 2 и записывать остатки в обратном порядке. Например, число 5 в двоичной системе будет выглядеть как 101. Понимание этого процесса — это первый шаг к изучению того, как работают алгоритмы и компьютерная память.',
        'summary_list' => [
            'Узнали, что такое основание системы счисления',
            'Поняли, почему компьютер использует именно 0 и 1',
            'Разобрали метод «деления столбиком» для перевода чисел'
        ],
        'quiz' => [
            'question' => 'Как будет выглядеть число 2 в двоичной системе счисления?',
            'answer' => '10'
        ]
    ];
?>

<div class="lesson-page-container">
    <h1>Основы систем счисления</h1>

    <div class="lesson-progress-container">
        <div class="lesson-progress-bar" id="myBar"></div>
    </div>

    <div class="lesson-video-wrapper">
        <video controls poster="/assets/img/video-placeholder.jpg" style="width:100%; height:100%; border-radius: 25px;">
            <source src="https://drive.google.com/uc?export=download&id=<?= $data['video_drive_id'] ?>" type="video/mp4">
            Ваш браузер не поддерживает встроенные видео.
        </video>
    </div>

    <div class="lesson-audio-card">
        <strong>🎧 Слушать урок:</strong>
        <audio controls src="<?= $data['audio_url'] ?>"></audio>
    </div>

    <div class="lesson-text-content">
        <p><?= $data['text_block_1'] ?></p>
        
        <?php if(!empty($data['image_url'])): ?>
            <img src="<?= $data['image_url'] ?>" class="lesson-image">
        <?php endif; ?>

        <p><?= $data['text_block_2'] ?></p>
    </div>

    <?php if ($lesson['interactive_slug'] !== 'none'): ?>
        <div id="interactive-root"></div>
        <script src="/assets/interactives/<?= $lesson['interactive_slug'] ?>/script.js"></script>
    <?php endif; ?>

    <div class="lesson-summary-plate">
        <h3>Коротко о главном:</h3>
        <ul>
            <?php foreach($data['summary_list'] as $item): ?>
                <li><?= $item ?></li>
            <?php endforeach; ?>
        </ul>
    </div>

    <button class="lesson-primary-btn" onclick="showQuiz()">Урок пройден!</button>

    <div id="quiz-block" class="lesson-quiz-box">
        <h3>Проверка знаний</h3>
        <p><?= $data['quiz']['question'] ?></p>
        <input type="text" id="user-answer" placeholder="Введите ответ...">
        <button class="lesson-primary-btn" onclick="checkAnswer('<?= $data['quiz']['answer'] ?>')">Проверить</button>
    </div>
</div>