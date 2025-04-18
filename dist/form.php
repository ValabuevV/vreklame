<?php
header('Content-Type: text/html; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Проверка на заполнение скрытого поля (защита от ботов)
    if (!empty($_POST['age'])) {
        die('Спам-защита: форма отправлена роботом!');
    }

    // Проверка времени заполнения формы (минимум 3 секунды)
    if (isset($_SERVER['HTTP_REFERER'])) {
        $referer = parse_url($_SERVER['HTTP_REFERER']);
        if ($referer['host'] !== $_SERVER['HTTP_HOST']) {
            die('Неверный источник запроса!');
        }
    }

    // Очистка данных
    $name = htmlspecialchars(trim($_POST['name']), ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars(trim($_POST['email']), ENT_QUOTES, 'UTF-8');
    $question = htmlspecialchars(trim($_POST['question']), ENT_QUOTES, 'UTF-8');

    // Проверка обязательных полей
    if (empty($name) || empty($email) || empty($question)) {
        die('Заполните все поля!');
    }

    // Валидация email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die('Некорректный email!');
    }

    // Отправка письма
    $to = 'pokrovskayamariya61@gmail.com, send@valabuev.ru'; // Замените на свою почту
    $subject = 'Вопрос с сайта';
    $message = "Имя: $name\nПочта: $email\nВопрос:\n$question";
    $headers = "From: $email\r\n";
    $headers .= "Content-type: text/plain; charset=utf-8\r\n";

    if (mail($to, $subject, $message, $headers)) {
        echo 'Сообщение отправлено! <a href="/">Вернуться</a>';
    } else {
        echo 'Ошибка при отправке! <a href="/">Вернуться</a>';
    }
} else {
    die('Неверный метод запроса!');
}
?>