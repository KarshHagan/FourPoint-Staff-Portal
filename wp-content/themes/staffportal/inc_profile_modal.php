<!-- profile modal -->
<div class="profile-modal">
  <div class="container shadow-border modal-panel">
  <div class="intro-wrap">
    <h1 class="container">profile modal<span class="close-modal" id="profile-modal"><img src="/wp-content/themes/staffportal/assets/images/icons/icon_close_blu.svg" /></span></h1>
    <p>Instructions Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
    tempor incididunt ut labore et dolore magna aliqua.</p>
  </div>
    <div class="photo-edit">
      <img class="profile-img" src="/wp-content/themes/fourpoint/assets/images/frenchy.jpg">
      <form>
        <label for="profile-photo-upload">Edit Photo</label>
        <input type="file" id="profile-photo-upload">
      </form>
    </div>
    <div class="container form-container">
      <form>
        <div class="form-group">
          <label for="name">Name</label>
          <input type="name" class="form-control" id="name" placeholder="Name">
        </div>
        <div class="form-group">
          <label for="title">Title</label>
          <input type="title" class="form-control" id="title" placeholder="Title">
        </div>
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" class="form-control" id="email" placeholder="Email">
        </div>

        <div class="form-group">
          <label for="outside-dial">Outside Dial</label>
          <input type="outside-dial" class="form-control" id="outside-dial" placeholder="Outside Dial">
        </div>

        <div class="form-group">
          <label for="mobile">Mobile</label>
          <input type="mobile" class="form-control" id="mobile" placeholder="Mobile">
        </div>

        <div class="form-group">
          <label for="conf-call">Conf. Call ID</label>
          <input type="conf-call" class="form-control" id="conf-call" placeholder="Conf. Call ID">
        </div>

        <div class="form-group">
          <label for="bio">Bio</label>
          <textarea rows="6" cols="50" class="form-control" id="bio" placeholder="Enter your bio"></textarea>
        </div>
        <button type="submit" class="button btn-blue">Save Changes</button>
      </form>
    </div>
  </div>
</div>
