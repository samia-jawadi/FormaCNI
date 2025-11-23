@extends('layouts.formateur')

@section('title', 'Modifier la Formation')
@section('page-title', 'Modifier la formation')

@section('content')
<div class="card p-6 rounded-xl max-w-3xl">
  @if($errors->any())
    <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
      <ul class="list-disc list-inside text-red-700">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ route('formateur.formations.update', $formation) }}" class="space-y-5">
    @csrf
    @method('PUT')

    <div>
      <label class="block text-sm font-medium mb-2">Description <span class="text-red-500">*</span></label>
      <textarea name="description" rows="6" required class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('description', $formation->description) }}</textarea>
    </div>

    <div class="flex items-center justify-end space-x-3 pt-2">
      <a href="{{ route('formateur.formations.index') }}" class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-800">Annuler</a>
      <button type="submit" class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white">Enregistrer</button>
    </div>
  </form>
</div>
@endsection
