<ul>
    @for ($i = 0; $i < 10; $i++)
        <li>
            <a class="history-item">
                <span class="bookmark_cd">{{$i+1}}</span><span class="bookmark_nm text-overfollow" maxlength="30">{{isset($search_history[$i])?$search_history[$i]['vocabulary_nm']:''}}</span>
            </a>
        </li>
    @endfor
</ul>


