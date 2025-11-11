@extends('layouts.frontend')
@section('content')
<div class="rbt-breadcrumb-default ptb--100 ptb_md--50 ptb_sm--30 bg-gradient-1">
  <div class="container">
      <div class="row">
          <div class="col-lg-12">
              <div class="breadcrumb-inner text-center">
                  <h2 class="title">Email Verification</h2>
                  <ul class="page-list">
                      <li class="rbt-breadcrumb-item"><a href="index.html">Home</a></li>
                      <li>
                          <div class="icon-right"><i class="feather-chevron-right"></i></div>
                      </li>
                      <li class="rbt-breadcrumb-item active">Email Verification</li>
                  </ul>
              </div>
          </div>
      </div>
  </div>
</div>
<style>


    form {
      padding: 2rem;
      border-radius: 4px;
      box-shadow: -1px 8px 11px rgb(0 0 0 / 10%);
      max-width: 700px;
      background: #fff;
      
      .form-control {
        display: block;
        height: 50px;
        margin-right: 0.5rem;
        text-align: center;
        font-size: 1.25rem;
        min-width: 0;
        
        &:last-child {
          margin-right: 0;
        }
      }
    }
    
    .form-control {
        margin: 0px 5px;
        display: block;
        width: 100%;
        padding: 1.375rem 0.75rem;
        font-size: 1rem;
        line-height: 1.5;
        color: #495057;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    }
    </style>
    
    <div class="container">
        <div class="row">
            <div class="col-md-2"></div>
                <div class="col-md-8 mt-10" style="padding-top: 106px;padding-bottom: 66px;">
                    <p style="font-weight: 500;font-family: 'Flaticon';font-size: 18px;color: red;">Please check your email for the 6-digit verification code to continue with your exam booking.</p>
                    <form method="POST" action="{{ route('verify.code') }}"> 
                                    @csrf
                        <h4 class="text-center mb-4">Enter your code</h4>
                        <input type="number" hidden value="{{ $id }}" name="id">
                        <div class="d-flex mb-3">
                            <input type="tel"  name="first" maxlength="1" pattern="[0-9]" class="form-control">
                            <input type="tel"  name="second" maxlength="1" pattern="[0-9]" class="form-control">
                            <input type="tel"  name="third" maxlength="1" pattern="[0-9]" class="form-control">
                            <input type="tel"  name="forth" maxlength="1" pattern="[0-9]" class="form-control">
                            <input type="tel"  name="five" maxlength="1" pattern="[0-9]" class="form-control">
                            <input type="tel"  name="six" maxlength="1" pattern="[0-9]" class="form-control">
                        </div>
                        <div class="form-submit-group">
                          <button type="submit" class="rbt-btn btn-md btn-gradient hover-icon-reverse w-100">
                              <span class="icon-reverse-wrapper">
                                  <span class="btn-text">Verify Email</span>
                                  <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                  <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                              </span>
                          </button>
                      </div>
                        {{-- <button type="submit" class="theme-btn btn-style-nine">Verify Email</button> --}}
                    </form>
    
                </div>
            </div>
        </div>
    </div>

<script>
    const form = document.querySelector('form')
    const inputs = form.querySelectorAll('input')
    const KEYBOARDS = {
      backspace: 8,
      arrowLeft: 37,
      arrowRight: 39,
    }
    
    function handleInput(e) {
      const input = e.target
      const nextInput = input.nextElementSibling
      if (nextInput && input.value) {
        nextInput.focus()
        if (nextInput.value) {
          nextInput.select()
        }
      }
    }
    
    function handlePaste(e) {
      e.preventDefault()
      const paste = e.clipboardData.getData('text')
      inputs.forEach((input, i) => {
        input.value = paste[i] || ''
      })
    }
    
    function handleBackspace(e) { 
      const input = e.target
      if (input.value) {
        input.value = ''
        return
      }
      
      input.previousElementSibling.focus()
    }
    
    function handleArrowLeft(e) {
      const previousInput = e.target.previousElementSibling
      if (!previousInput) return
      previousInput.focus()
    }
    
    function handleArrowRight(e) {
      const nextInput = e.target.nextElementSibling
      if (!nextInput) return
      nextInput.focus()
    }
    
    form.addEventListener('input', handleInput)
    inputs[0].addEventListener('paste', handlePaste)
    
    inputs.forEach(input => {
      input.addEventListener('focus', e => {
        setTimeout(() => {
          e.target.select()
        }, 0)
      })
      
      input.addEventListener('keydown', e => {
        switch(e.keyCode) {
          case KEYBOARDS.backspace:
            handleBackspace(e)
            break
          case KEYBOARDS.arrowLeft:
            handleArrowLeft(e)
            break
          case KEYBOARDS.arrowRight:
            handleArrowRight(e)
            break
          default:  
        }
      })
    })
    
    </script>
{{--
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
--}}
@endsection
