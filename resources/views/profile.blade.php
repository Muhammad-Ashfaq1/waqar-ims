@extends('common.master')

@section('content')
<div class="right_col bgimg" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left"><h3>My Profile</h3></div>
    </div>
    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-9 col-md-offset-1">

        <div class="as-card" id="as-root"
             data-active="{{ request('tab') === 'password' ? 'password' : 'profile' }}">

          {{-- ── Tabs ── --}}
          <ul class="as-tabs">
            <li>
              <a href="{{ url('profile') }}" data-tab="profile"
                 class="{{ request('tab') !== 'password' ? 'active' : '' }}">Profile</a>
            </li>
            <li>
              <a href="{{ url('profile?tab=password') }}" data-tab="password"
                 class="{{ request('tab') === 'password' ? 'active' : '' }}">Change Password</a>
            </li>
          </ul>

          {{-- ══════════════════════════════════
               PROFILE PANEL
          ══════════════════════════════════ --}}
          <div class="as-panel" data-panel="profile"
               @if(request('tab') === 'password') hidden @endif>

            <form method="POST" action="{{ url('profile') }}" enctype="multipart/form-data" id="form-profile" novalidate>
              @csrf
              @method('PUT')
              <input type="file" id="avatar-input" name="profile_image"
                     accept="image/jpeg,image/jpg,image/png,image/gif,image/webp"
                     style="display:none;">

              {{-- Avatar row --}}
              <div class="as-avatar-header">
                <label class="as-avatar-label" for="avatar-input" id="avatar-preview" title="Click to change photo">
                  <img src="{{ $user->profile_image_url }}" alt="{{ $user->name }}" id="avatar-img"
                       style="width:100%;height:100%;object-fit:cover;display:block;">
                </label>
                <div class="as-avatar-info">
                  <h4>{{ $user->name }}</h4>
                  <p>Update your profile information and settings.</p>
                  @error('profile_image')
                    <div class="as-error show" style="margin-top:6px;">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              {{-- Fields --}}
              <div class="as-row">
                <div class="as-col-half as-field">
                  <label class="as-label">First Name <span class="as-required">*</span></label>
                  <input type="text" id="f-firstname" name="first_name"
                         class="as-input {{ $errors->has('first_name') ? 'is-invalid' : '' }}"
                         value="{{ old('first_name', $user->first_name) }}"
                         placeholder="Enter first name" required maxlength="100" autofocus>
                  <div class="as-error {{ $errors->has('first_name') ? 'show' : '' }}" id="err-firstname">
                    {{ $errors->first('first_name') }}
                  </div>
                </div>

                <div class="as-col-half as-field">
                  <label class="as-label">Last Name <span class="as-required">*</span></label>
                  <input type="text" id="f-lastname" name="last_name"
                         class="as-input {{ $errors->has('last_name') ? 'is-invalid' : '' }}"
                         value="{{ old('last_name', $user->last_name) }}"
                         placeholder="Enter last name" required maxlength="100">
                  <div class="as-error {{ $errors->has('last_name') ? 'show' : '' }}" id="err-lastname">
                    {{ $errors->first('last_name') }}
                  </div>
                </div>

                <div class="as-col-half as-field">
                  <label class="as-label">Email</label>
                  <input type="email" class="as-input" value="{{ $user->email }}" disabled>
                </div>

                <div class="as-col-half as-field">
                  <label class="as-label">Mobile Number</label>
                  <input type="text" id="f-mobile" name="mobile"
                         class="as-input {{ $errors->has('mobile') ? 'is-invalid' : '' }}"
                         value="{{ old('mobile', $user->mobile) }}"
                         placeholder="e.g. 0300-1234567" maxlength="20">
                  <div class="as-error {{ $errors->has('mobile') ? 'show' : '' }}" id="err-mobile">
                    {{ $errors->first('mobile') }}
                  </div>
                </div>
              </div>

              <div class="ln_solid"></div>
              <div class="as-actions">
                <button type="submit" class="btn btn-success">
                  <i class="fa fa-save"></i> Save Changes
                </button>
              </div>
            </form>
          </div>

          {{-- ══════════════════════════════════
               CHANGE PASSWORD PANEL
          ══════════════════════════════════ --}}
          <div class="as-panel" data-panel="password"
               @if(request('tab') !== 'password') hidden @endif>

            <p class="as-pw-title">Change Password</p>

            <form method="POST" action="{{ route('profile.password') }}" id="form-password" novalidate>
              @csrf
              @method('PUT')

              <div class="as-row">
                {{-- Current --}}
                <div class="as-col-half as-field">
                  <label class="as-label">Current Password <span class="as-required">*</span></label>
                  <div class="as-input-group {{ $errors->has('current_password') ? 'is-invalid' : '' }}" id="grp-cur">
                    <input type="password" id="f-cur" name="current_password"
                           class="as-input {{ $errors->has('current_password') ? 'is-invalid' : '' }}"
                           placeholder="Enter current password" required autocomplete="current-password">
                    <button type="button" class="as-pw-toggle" data-for="f-cur">
                      <svg id="eye-cur" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                  </div>
                  <div class="as-error {{ $errors->has('current_password') ? 'show' : '' }}" id="err-cur">
                    {{ $errors->first('current_password') }}
                  </div>
                </div>

                {{-- New --}}
                <div class="as-col-half as-field">
                  <label class="as-label">New Password <span class="as-required">*</span></label>
                  <div class="as-input-group" id="grp-new">
                    <input type="password" id="f-new" name="new_password"
                           class="as-input" placeholder="Enter new password"
                           required minlength="8" autocomplete="new-password">
                    <button type="button" class="as-pw-toggle" data-for="f-new">
                      <svg id="eye-new" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                  </div>
                  <div class="as-error" id="err-new"></div>
                </div>

                {{-- Confirm --}}
                <div class="as-col-half as-field">
                  <label class="as-label">Confirm New Password <span class="as-required">*</span></label>
                  <div class="as-input-group" id="grp-con">
                    <input type="password" id="f-con" name="new_password_confirmation"
                           class="as-input" placeholder="Re-enter new password"
                           required autocomplete="new-password">
                    <button type="button" class="as-pw-toggle" data-for="f-con">
                      <svg id="eye-con" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                  </div>
                  <div class="as-error" id="err-con"></div>
                </div>
              </div>

              <div class="ln_solid"></div>
              <div class="as-actions">
                <button type="submit" class="btn btn-warning">
                  <i class="fa fa-lock"></i> Change Password
                </button>
              </div>
            </form>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
(function(){
  var root = document.getElementById('as-root');
  if (!root) return;

  /* ── Tab switching ── */
  var tabs   = root.querySelectorAll('[data-tab]');
  var panels = root.querySelectorAll('[data-panel]');
  function activate(name, push) {
    var changed = root.dataset.active !== name;
    tabs.forEach(function(t){ t.classList.toggle('active', t.dataset.tab === name); });
    panels.forEach(function(p){ p.hidden = (p.dataset.panel !== name); });
    root.dataset.active = name;
    if (push && changed) {
      var url = name === 'password' ? '{{ url("profile?tab=password") }}' : '{{ url("profile") }}';
      history.pushState({tab:name}, '', url);
    }
  }
  tabs.forEach(function(t){
    t.addEventListener('click', function(e){ e.preventDefault(); activate(this.dataset.tab, true); });
  });
  window.addEventListener('popstate', function(e){
    activate((e.state && e.state.tab)||'profile', false);
  });

  /* ── Avatar preview ── */
  var avatarInput = document.getElementById('avatar-input');
  var avatarPreview = document.getElementById('avatar-preview');
  if (avatarInput && avatarPreview) {
    avatarInput.addEventListener('change', function(){
      var file = this.files && this.files[0];
      if (!file) return;
      if (['image/jpeg','image/jpg','image/png','image/gif','image/webp'].indexOf(file.type) === -1) return;
      if (file.size > 2*1024*1024) return;
      var r = new FileReader();
      r.onload = function(e){
        avatarPreview.innerHTML = '<img src="'+e.target.result+'" alt="Avatar" style="width:100%;height:100%;object-fit:cover;display:block;">';
      };
      r.readAsDataURL(file);
    });
  }

  /* ── Password eye toggles ── */
  var EYE     = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
  var EYE_OFF = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';
  document.querySelectorAll('.as-pw-toggle').forEach(function(btn){
    btn.addEventListener('click', function(){
      var input = document.getElementById(this.dataset.for);
      var svg   = this.querySelector('svg');
      if (!input || !svg) return;
      var hidden = input.type === 'password';
      input.type = hidden ? 'text' : 'password';
      svg.innerHTML = hidden ? EYE_OFF : EYE;
    });
  });

  /* ── Helpers ── */
  function setErr(errEl, grpEl, inputEl, msg) {
    if (errEl)   { errEl.textContent = msg||''; errEl.classList.toggle('show', !!msg); }
    if (inputEl) { inputEl.classList.toggle('is-invalid', !!msg); }
    if (grpEl)   { grpEl.classList.toggle('is-invalid', !!msg); }
  }

  /* ── Profile form ── */
  var pForm = document.getElementById('form-profile');
  var fFN   = document.getElementById('f-firstname');
  var fLN   = document.getElementById('f-lastname');
  var fMob  = document.getElementById('f-mobile');

  function chkFN(){
    var v=(fFN.value||'').trim();
    if(!v){setErr(document.getElementById('err-firstname'),null,fFN,'First name is required.');return false;}
    if(v.length>100){setErr(document.getElementById('err-firstname'),null,fFN,'Max 100 characters.');return false;}
    setErr(document.getElementById('err-firstname'),null,fFN,'');return true;
  }
  function chkLN(){
    var v=(fLN.value||'').trim();
    if(!v){setErr(document.getElementById('err-lastname'),null,fLN,'Last name is required.');return false;}
    if(v.length>100){setErr(document.getElementById('err-lastname'),null,fLN,'Max 100 characters.');return false;}
    setErr(document.getElementById('err-lastname'),null,fLN,'');return true;
  }
  function chkMob(){
    var v=(fMob.value||'').trim();
    if(v.length>20){setErr(document.getElementById('err-mobile'),null,fMob,'Max 20 characters.');return false;}
    setErr(document.getElementById('err-mobile'),null,fMob,'');return true;
  }
  if(pForm){
    fFN.addEventListener('input',chkFN);
    fLN.addEventListener('input',chkLN);
    fMob.addEventListener('input',chkMob);
    pForm.addEventListener('submit',function(e){
      if(!chkFN()|!chkLN()|!chkMob()){e.preventDefault();(pForm.querySelector('.is-invalid')||fFN).focus();}
    });
  }

  /* ── Password form ── */
  var pwForm = document.getElementById('form-password');
  var fCur=document.getElementById('f-cur'), grpCur=document.getElementById('grp-cur'), errCur=document.getElementById('err-cur');
  var fNew=document.getElementById('f-new'), grpNew=document.getElementById('grp-new'), errNew=document.getElementById('err-new');
  var fCon=document.getElementById('f-con'), grpCon=document.getElementById('grp-con'), errCon=document.getElementById('err-con');

  function chkCur(){
    if(!(fCur.value||'').trim()){setErr(errCur,grpCur,fCur,'Current password is required.');return false;}
    setErr(errCur,grpCur,fCur,'');return true;
  }
  function chkNew(){
    var v=fNew.value||'';
    if(!v){setErr(errNew,grpNew,fNew,'New password is required.');return false;}
    if(v.length<8){setErr(errNew,grpNew,fNew,'Password must be at least 8 characters.');return false;}
    setErr(errNew,grpNew,fNew,'');return true;
  }
  function chkCon(){
    if(!fCon.value){setErr(errCon,grpCon,fCon,'Please confirm your new password.');return false;}
    if(fCon.value!==fNew.value){setErr(errCon,grpCon,fCon,'Passwords do not match.');return false;}
    setErr(errCon,grpCon,fCon,'');return true;
  }
  if(pwForm){
    fCur.addEventListener('input',chkCur);
    fNew.addEventListener('input',function(){chkNew();if(fCon.value)chkCon();});
    fCon.addEventListener('input',chkCon);
    pwForm.addEventListener('submit', function(e){
      e.preventDefault();
      var ok = chkCur() & chkNew() & chkCon();
      if (!ok) {
        (pwForm.querySelector('.is-invalid') || fCur).focus();
        return;
      }

      var btn = pwForm.querySelector('button[type="submit"]');
      var origHTML = btn.innerHTML;
      btn.disabled = true;
      btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Changing...';

      var formData = new FormData(pwForm);

      fetch(pwForm.action, {
        method: 'POST',
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
          'Accept': 'application/json'
        },
        body: formData
      })
      .then(function(res){
        return res.json().then(function(data){ return { status: res.status, data: data }; });
      })
      .then(function(resObj){
        btn.disabled = false;
        btn.innerHTML = origHTML;
        var data = resObj.data;

        if (resObj.status === 200 && data.success) {
          if (typeof toastr !== 'undefined' && toastr.success) { toastr.success(data.message || 'Password changed successfully.'); }
          else if (typeof flasher !== 'undefined') { flasher.success(data.message || 'Password changed successfully.'); }
          pwForm.reset();
          setErr(errCur, grpCur, fCur, '');
          setErr(errNew, grpNew, fNew, '');
          setErr(errCon, grpCon, fCon, '');
        } else {
          var msg = (data && data.message) ? data.message : 'Current password is incorrect.';
          if (typeof toastr !== 'undefined' && toastr.error) { toastr.error(msg); }
          else if (typeof flasher !== 'undefined') { flasher.error(msg); }
          else { alert(msg); }
          setErr(errCur, grpCur, fCur, msg);
          fCur.focus();
        }
      })
      .catch(function(){
        btn.disabled = false;
        btn.innerHTML = origHTML;
        var msg = 'Current password is incorrect.';
        if (typeof toastr !== 'undefined' && toastr.error) { toastr.error(msg); }
        else if (typeof flasher !== 'undefined') { flasher.error(msg); }
        else { alert(msg); }
        setErr(errCur, grpCur, fCur, msg);
        fCur.focus();
      });
    });
  }
})();
</script>
@endpush
