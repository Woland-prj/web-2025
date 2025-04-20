<?php

function renderProfile($profile)
{
  $galeryHtml = "";

  foreach ($profile['galery'] as $index => $galeryItem) {
    $galeryHtml .= getGaleryItemHtml($galeryItem, $index);
  }

  $postsCount = count($profile['galery']);
  echo
  <<<HTML
      <div class="profile">
          <div class="profile__header">
              <img
                  class="profile__avatar"
                  src="{$profile['avatar']}"
                  alt="Аватар пользователя {$profile['name']}"
              />
              <h1 class="profile__name">{$profile['name']}</h1>
              <p class="profile__bio">{$profile['bio']}</p>
              <div class="profile__posts-count">
                  <img src="../images/icons/posts.svg" alt="Посты" />
            <span class="profile__posts-count-text">{$postsCount} постов</span>
              </div>
          </div>

          <div class="gallery">
              {$galeryHtml}
          </div>
      </div>
  HTML;
}

function getGaleryItemHtml($galeryItem, int $index)
{
  return
    <<<HTML
      <div class="gallery__item">
          <img
              src="{$galeryItem}"
              alt="Фото галереи {$index}"
          />
      </div>
  HTML;
}
