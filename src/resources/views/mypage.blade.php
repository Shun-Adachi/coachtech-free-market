@extends('layouts.app')
@extends('layouts.search')
@extends('layouts.link')

@section('css')
<link rel="stylesheet" href="{{ asset('css/common/user-common.css')}}">
<link rel="stylesheet" href="{{ asset('css/common/item-common.css')}}">
<link rel="stylesheet" href="{{ asset('css/mypage.css')}}">
@endsection

@section('content')
<!-- ユーザー情報 -->
<form class="profile-image-form__form" action="/edit-profile" method="post">
  @csrf
  <div class="profile-image-form__group">
    <img
      class="profile-image-form__image"
      src="{{ $profileImage ?? 'images/default-profile.png'}}"
      alt="プロフィール画像">
    <p class="profile-image-form__label" type="submit">ユーザー名</p>
    <input class="profile-image-form__button" type="submit" value="プロフィールを編集">
  </div>
</form>
<!-- ヘッダータブ -->
<div class="item-header">
  <a class="item-header__link" href="/mypage">出品した商品</a>
  <a class="item-header__link--active" href="/mypage">購入した商品</a>
</div>
<!-- アイテムリスト -->
<div class="item-list">
  @for ($i = 0; $i < 5; $i++)
    <div class="item-card">
    <a class="item-card__link" href=" /detail">
      <img class="item-card__image" src="./images/default-profile.png" />
    </a>
    <p class="item-card__label">商品名</p>
</div>
@endfor
</div>

</div>
@endsection('content')