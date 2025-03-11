import { MusicPlayer } from './musicPlayer.js';
import { setupFormHandlers } from './forms.js';
import { storeInSession, getFromSession } from './utils.js';

// Initialize modules
document.addEventListener('DOMContentLoaded', () => {
  // Music Player
  if (document.querySelector('audio')) {
    new MusicPlayer();
  }

  // Forms
  setupFormHandlers();

  // Session Management
  const currentUser = getFromSession('currentUser');
  if (!currentUser && window.location.pathname !== '/login.php') {
    window.location.href = 'login.php';
  }
});

// Search Functionality
document.querySelector('#searchInput')?.addEventListener('input', async (e) => {
  const searchTerm = e.target.value;
  const response = await makeRequest(`api/search.php?q=${encodeURIComponent(searchTerm)}`);
  
  if (response.success) {
    this.updateSongList(response.data);
  }
});

// Update UI with search results
function updateSongList(songs) {
  const songList = document.querySelector('#songList');
  songList.innerHTML = songs.map(song => `
    <div class="song-item">
      <h5>${song.title}</h5>
      <p>${song.artist}</p>
      <audio controls src="${song.file_path}"></audio>
    </div>
  `).join('');
}