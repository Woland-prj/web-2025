<?php
include '../utils/words_formatter.php';
include '../utils/time.php';

function getFormattedCreationDate($post) {
    $daysAgo = getAgoTime($post['created_at']);

    return match (true) {
        $daysAgo == 0 => 'сегодня',
        $daysAgo == 1 => 'вчера',
        default => "$daysAgo " . pluralForm($daysAgo, 'день', 'дня', 'дней') . " назад",
    };
}

function renderPost($post,  $likeRecords): void
{
    $imgsHtml = "";

    foreach ($post['images'] as $index => $img) {
        $imgsHtml .= "<img src='{$img}' alt='Post image' class='image__picture'/>";
    }

    $daysAgo = getAgoTime($post['created_at']);

    $creationDateText = getFormattedCreationDate($post);

    $liked = array_filter($likeRecords, fn($record) => (string)$record['post_id'] === (string)$post['id']);
    $likesClass = 'post__likes' . (!empty($liked) ? ' post__likes_active' : '');

    echo <<<HTML
        <div class='post' id="{$post['id']}">
            <div class='post__header'>
                <div class='post__header-name'>
                    <a href='profile.php?id={$post['author']['id']}'><img class='post__avatar' src='{$post['author']['avatar']}' alt='Аватар {$post['author']['name']}'></a>
                    <span class='post__author'>{$post['author']['name']}</span>
                </div>
            </div>
            <div class='post__image'>
                {$imgsHtml}
                <div class='post__image-index'>1/3</div>
                <div class='post__image-buttons'>
                    <button class='post__image-button'>
                        <img src='../images/icons/arrow_left.svg' class='post__image-button-icon'/>
                    </button>
                    <button class='post__image-button'>
                        <img src='../images/icons/arrow_right.svg' class='post__image-button-icon'/>
                    </button>
                </div>
            </div>
            <div class='post__footer'>
                <div class="{$likesClass}">❤️ <span class='post__likes-count'>{$post['likes']}</span></div>
                <p class='post__text'>{$post['text']}</p>
                <div class='post__show-text-button'>ещё</div>
                <div class='post__timestamp'>{$creationDateText}</div>
            </div>
      </div>
  HTML;
}
