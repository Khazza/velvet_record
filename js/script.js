document.addEventListener('DOMContentLoaded', function() {
    // -------------------------Supression disc-------------------------
    function deleteDisc(id) {
      // ...
    }
  
    // ----------------------------------Login------------------------------------
    const urlParams = new URLSearchParams(window.location.search);
    const login = urlParams.get('login');
  
    if (login === 'success') {
      Swal.fire({
        title: 'Connecté avec succès!',
        text: 'Bienvenue!',
        icon: 'success',
        confirmButtonText: 'Cool',
        confirmButtonColor: '#6e0a19'
      }).then(() => {
        history.replaceState(null, '', 'index.php');
      });
    }
  
    // ----------------------------------Logout-----------------------------------
    const logout = urlParams.get('logout');
  
    if (logout === 'success') {
      Swal.fire({
        title: 'Déconnecté avec succès!',
        text: 'Vous avez été déconnecté de votre compte.',
        icon: 'success',
        confirmButtonText: 'Cool',
        confirmButtonColor: '#6e0a19'
      }).then(() => {
        history.replaceState(null, '', 'index.php');
      });
    }
  
    // ----------------------------------Signup-----------------------------------
    $(document).ready(function() {
      if (typeof register_success !== 'undefined' && register_success) {
        Swal.fire(
          'Inscription réussie !',
          register_success,
          'success',
          {
            confirmButtonColor: '#6e0a19'
          }
        ).then(() => {
          history.replaceState(null, '', 'index.php');
        });
      }
    });
  
    // ----------------------------------Artiste-----------------------------------
    document.getElementById('artist').addEventListener('change', function() {
      // ...
    });
  
    // ----------------------------------Form Edit----------------------------------
    $(document).ready(function() {
      $('form').submit(function(e) {
        // ...
      });
    });
  
    // -----------------------------Password
    const passwordInput = document.getElementById('password');
    const togglePasswordButton = document.getElementById('togglePassword');
  
    togglePasswordButton.addEventListener('click', function() {
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        togglePasswordButton.innerHTML = '<i class="fas fa-eye-slash"></i>';
      } else {
        passwordInput.type = 'password';
        togglePasswordButton.innerHTML = '<i class="fas fa-eye"></i>';
      }
    });
  });
  