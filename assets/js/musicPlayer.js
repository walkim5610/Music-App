export class MusicPlayer {
    constructor() {
      this.audioElement = document.querySelector('audio');
      this.playPauseBtn = document.querySelector('#play-pause');
      this.progressBar = document.querySelector('#progress-bar');
      this.volumeControl = document.querySelector('#volume');
      this.currentTimeDisplay = document.querySelector('#current-time');
      this.durationDisplay = document.querySelector('#duration');
  
      this.initialize();
    }
  
    initialize() {
      if (this.audioElement) {
        this.audioElement.volume = 0.5; // Default volume
        
        // Event listeners
        this.audioElement.addEventListener('timeupdate', this.updateProgress.bind(this));
        this.playPauseBtn.addEventListener('click', this.togglePlay.bind(this));
        this.volumeControl.addEventListener('input', this.setVolume.bind(this));
        this.progressBar.addEventListener('input', this.seek.bind(this));
      }
    }
  
    togglePlay() {
      if (this.audioElement.paused) {
        this.audioElement.play();
        this.playPauseBtn.innerHTML = '<i class="fas fa-pause"></i>';
      } else {
        this.audioElement.pause();
        this.playPauseBtn.innerHTML = '<i class="fas fa-play"></i>';
      }
    }
  
    setVolume() {
      this.audioElement.volume = this.volumeControl.value;
    }
  
    updateProgress() {
      const progress = (this.audioElement.currentTime / this.audioElement.duration) * 100;
      this.progressBar.value = progress;
      this.currentTimeDisplay.textContent = this.formatTime(this.audioElement.currentTime);
      this.durationDisplay.textContent = this.formatTime(this.audioElement.duration);
    }
  
    seek() {
      const seekTime = (this.progressBar.value / 100) * this.audioElement.duration;
      this.audioElement.currentTime = seekTime;
    }
  
    formatTime(seconds) {
      const minutes = Math.floor(seconds / 60);
      seconds = Math.floor(seconds % 60);
      return `${minutes}:${seconds.toString().padStart(2, '0')}`;
    }
  }