<?php

function renderPost($post)
{
  $creationDate = date('d', $post['created_at']);
  echo <<<HTML
      <div class='post'>
            <div class='post__header'>
                <div class='post__header-name'>
                    <a href='profile.php?id={$post['author']['id']}'><img class='post__avatar' src='{$post['author']['avatar']}' alt='Аватар {$post['author']['name']}'></a>
                    <span class='post__author'>{$post['author']['name']}</span>
                </div>
            </div>
            <div class='post__image'>
                <img src='{$post['images'][0]}' alt='Post image' />
                    <div class='post__image-index'>1/3</div>
                    <div class='post__image-buttons'>
                        <button class='post__image-button'>
                            <object
                                data='../images/icons/arrow_left.svg'
                                type='image/svg+xml'
                                class='post__image-button-icon'
                            ></object>
                        </button>
                        <button class='post__image-button'>
                            <object
                                data='../images/icons/arrow_right.svg'
                                type='image/svg+xml'
                                class='post__image-button-icon'
                            ></object>
                        </button>
                    </div>
            </div>
            <div class='post__footer'>
                <div class='post__likes'>❤️ <span class='post__likes-count'>{$post['likes']}</span></div>
                <p class='post__text'>{$post['text']}</p>
                <span class='post__timestamp'>{$creationDate} дня назад</span>
            </div>
      </div>
  HTML;
}
