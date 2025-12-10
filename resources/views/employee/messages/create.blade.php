@extends('layouts.dashboard')

@section('title', 'New Message - Contact Administration')

@section('content')
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="fas fa-plus"></i>
                    </div>
                    <div>
                        <h1>New Message</h1>
                        <div class="page-title-subheading">
                            Send a message to administration
                        </div>
                    </div>
                </div>
                <div class="page-title-actions">
                    <a href="{{ route('employee.messages.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Messages
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h5 class="card-title">Compose Message</h5>
                        <p class="text-muted">
                            Use this form to send messages, questions, or requests to the administration team.
                            We will review your message and respond accordingly.
                        </p>

                        <form action="{{ route('employee.messages.store') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label for="subject">Subject *</label>
                                <input type="text"
                                       class="form-control @error('subject') is-invalid @enderror"
                                       id="subject"
                                       name="subject"
                                       value="{{ old('subject') }}"
                                       required
                                       placeholder="Brief description of your message">
                                @error('subject')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="message">Message *</label>
                                <textarea class="form-control @error('message') is-invalid @enderror"
                                          id="message"
                                          name="message"
                                          rows="8"
                                          required
                                          placeholder="Please provide details about your message, question, or request...">{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i>
                                    <strong>Note:</strong> This message will be sent to the administration team.
                                    Please be clear and specific about what you need.
                                </div>
                            </div>

                            <div class="form-group text-right">
                                <a href="{{ route('employee.messages.index') }}" class="btn btn-secondary mr-2">
                                    <i class="fas fa-times"></i> Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane"></i> Send Message
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

@push('styles')
<style>
.form-group label {
    font-weight: 600;
    color: #495057;
    margin-bottom: 8px;
}

.alert-info {
    border-left: 4px solid #17a2b8;
}
</style>
@endpush
