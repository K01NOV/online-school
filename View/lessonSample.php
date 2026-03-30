<div class="lesson-page-container">
    <?php 
        foreach($content as $piece){
            $type = $piece['type'];
            if(isset($piece['value'])){
                $value = $piece['value'];
            }
            switch($type){
                case 'header':
                    echo "<h1>$value</h1>";
                    break;
                //case 'video':
                    $title = $piece['title'];
                    echo "
                        <div class=\"lesson-video-wrapper\">
                            <video controls width=\"640\" height=\"360\">
                                <source src=\"https://cloud.mail.ru/home/video/%D1%88%D0%B8%D1%84%D1%80%20%D1%86%D0%B5%D0%B7%D0%B0%D1%80%D1%8F.mp4\" type=\"video/mp4\">
                                Ваш браузер не поддерживает встроенное видео.
                            </video>
                        </div>

                    ";
                    break;
                case 'image':
                    echo "
                        <img src=\"$value\" class=\"lesson-image\" referrerpolicy=\"no-referrer\">
                    ";
                    break;
                //case 'audio':
                    echo "
                        <iframe class=\"lesson-audio-card\" src=\"https://drive.google.com/file/d/$value/preview\" 
                                allow=\"autoplay\">
                        </iframe>
                    ";
                    break;
                case 'quiz':
                    $quizzes[] = $piece;
                    break;
                case 'short':
                    $shortForm = $piece;
                    break;
                case 'list':
                    echo "
                        <h3>$value</h3><ul>
                    ";
                    foreach($piece['li'] as $li){
                        echo "<li>$li</li>";
                    }
                    echo "</ul>";
                    break;
                case 'text':
                    echo "
                        <p>$value</p>
                    ";
                    break;
            }

        }
        if(isset($shortForm)){
            echo "<div class=\"lesson-summary-plate\">
                <h3>Коротко о главном:</h3>
                <ul>";
            foreach($shortForm['value'] as $li){
                echo "<li>$li</li>";
            }
            echo "</ul></div>";
        }
    ?>

    <button class="lesson-primary-btn" onclick="showQuiz()">Урок пройден!</button>
    <div id="quiz-block" class="lesson-quiz-box">
        <h3>Проверка знаний</h3>
        <?php foreach($quizzes as $i => $quiz): ?>
            <div class="quiz-item" id="quiz-<?= $i ?>">
                <p><strong><?= $quiz['q'] ?></strong></p>
                <div class="quiz-feedback" style="font-weight: bold; margin-bottom: 10px; min-height: 1.2em;"></div>
                <?php 
                $correct = $quiz['correct'];
                
                if($quiz['subtype'] == 'input'): ?>
                    <input type="text" class="quiz-answer-input" placeholder="Введите ответ...">
                    <button class="lesson-primary-btn" onclick="checkAnswer(this, '<?= $correct ?>')">Проверить</button>

                <?php elseif($quiz['subtype'] == 'choice'): 
                    $type = is_array($correct) ? 'checkbox' : 'radio';
                    $name = "quiz_group_" . $i;
                    
                    foreach($quiz['a'] as $a): ?>
                        <label style="display: flex; gap: 20px">
                            <input type="<?= $type ?>" name="<?= $name ?>" value="<?= $a ?>"> 
                            <?= $a ?>
                        </label>
                    <?php endforeach; ?>
                    <button class="lesson-primary-btn" onclick="checkAnswer(this, <?= htmlspecialchars(json_encode($correct)) ?>)">Проверить</button>
                <?php endif; ?>
            </div>
            <br>
            <hr>
        <?php endforeach; ?>
    </div>

    <div id="final-result-card" class="lesson-result-box">
        <h3>Урок завершен</h3>
        <div style="font-size: 24px; margin: 15px 0;">
            Ваш результат: <span id="percent-result" style="font-weight: bold; color: #3498db;">0%</span>
        </div>
        <p id="result-comment"></p>
        
        <a href="/subject-info?id=<?= htmlspecialchars($subject_id) ?>" id="back-to-subject" class="lesson-primary-btn" style="pointer-events: none; background: dodgerblue">
            Вернуться к предмету
        </a>
    </div>
</div>
