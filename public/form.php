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
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $question = htmlspecialchars(trim($_POST['question']));

    // Проверка обязательных полей
    if (empty($name) || empty($email) || empty($question)) {
        die('Заполните все поля!');
    }

    // Валидация email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die('Некорректный email!');
    }

    // Отправка письма
    $to = 'send@valabuev.ru'; // Замените на свою почту
    $subject = 'Вопрос с сайта';
    //$message = "Имя: $name\nПочта: $email\nВопрос:\n$question";
    $message = "test";
    $headers = "From: $email";

    if (mail($to, $subject, $message, $headers)) {
        echo 'Сообщение отправлено! <a href="/">Вернуться</a>';
    } else {
        print_r(error_get_last(), true);
        echo 'Ошибка при отправке! <a href="/">Вернуться</a>';
    }
} else {
    die('Неверный метод запроса!');
}
?>