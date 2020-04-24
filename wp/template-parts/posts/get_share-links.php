<ul>
  <li>
    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink() ?>" target="_blank" rel="noopener">Share</a>
  </li>
  <li>
    <a href="https://twitter.com/home?status=<?php the_permalink() ?>&text=<?php the_title() ?>" target="_blank" rel="noopener">Tweet</a>
  </li>
  <li>
    <a href="https://pinterest.com/pin/create/button/?url=<?php the_permalink() ?>&media=<?= get_field('imagem')['sizes']['thumbnail'] ?>&description=<?php the_title() ?>" target="_blank" rel="noopener">Save</a>
  </li>
  <li>
    <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink() ?>&title=&summary=<?php the_title() ?>&source=" target="_blank" rel="noopener">Share</a>
  </li>
</ul>
