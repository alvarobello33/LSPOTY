<div id="playerBar">
    <div id="playerBar-info">
        <!-- Título y artista -->
        <span id="playerBar-title"><?=lang('app.playerBarSong')?></span>
        <span id="playerBar-artist"></span>
    </div>

    <!-- Controles izquierda -->
    <div class="extra-controls left-controls">
        <button id="prevBtn" class="player-extra-btn" title="Canción anterior">
            <i class="fas fa-step-backward"></i>
        </button>
    </div>

    <audio id="playerBar-audio" controls></audio>

    <!-- Controles derecha -->
    <div class="extra-controls right-controls">
        <button id="nextBtn" class="player-extra-btn" title="Siguiente canción">
            <i class="fas fa-step-forward"></i>
        </button>
        <button id="loopBtn" class="player-extra-btn" title="Repetir playlist">
            <i class="fas fa-redo"></i>
        </button>
    </div>
</div>
