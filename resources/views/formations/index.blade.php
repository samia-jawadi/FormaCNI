@extends('layouts.participant')

@section('title', 'Toutes les Formations - FormaCNI')

@section('page-title', 'Formations Disponibles')

@section('content')
<div class="mb-6">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Formations Disponibles</h2>
            <p class="text-gray-600 dark:text-gray-400">Découvrez toutes nos formations et développez vos compétences</p>
        </div>
        <div class="flex items-center space-x-4">
            <div class="relative">
                <input type="text" id="search-formation" placeholder="Rechercher une formation..." 
                       class="input-field pl-10 pr-4 py-2 rounded-lg w-64">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
            </div>
            <select id="filter-niveau" class="input-field px-4 py-2 rounded-lg">
                <option value="">Tous les niveaux</option>
                <option value="debutant">Débutant</option>
                <option value="intermediaire">Intermédiaire</option>
                <option value="avance">Avancé</option>
            </select>
            <select id="filter-status" class="input-field px-4 py-2 rounded-lg">
                <option value="">Tous les statuts</option>
                <option value="ACTIVE">Actives</option>
                <option value="available">Places disponibles</option>
            </select>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <div class="card p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-emerald-100 text-emerald-600 mr-4">
                <i class="fas fa-play-circle text-xl"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Formations Actives</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ \App\Models\Formation::where('statut', 'ACTIVE')->count() }}
                </p>
            </div>
        </div>
    </div>
    
    <div class="card p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4">
                <i class="fas fa-user-check text-xl"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Mes Inscriptions</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ Auth::user()->inscriptions()->count() }}
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Formations Grid -->
<div class="card">
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
            <i class="fas fa-search mr-2"></i>Parcourir les Formations
        </h3>
    </div>
    <div class="p-6">
        <div id="formations-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse(\App\Models\Formation::where('statut', 'ACTIVE')->where('terminee', false)->get() as $formation)
            <div class="formation-card bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6 hover:shadow-lg transition-all duration-300 hover:-translate-y-1" 
                 data-niveau="{{ strtolower($formation->niveau ?? 'debutant') }}" 
                 data-status="{{ $formation->peutEtreInscrit() ? 'available' : 'full' }}">
                
                <!-- Formation Header -->
                <div class="flex justify-between items-start mb-4">
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ $formation->titre }}</h3>
                        <div class="flex items-center text-gray-600 dark:text-gray-400 text-sm mb-1">
                            <i class="far fa-calendar-alt mr-2"></i>
                            <span>{{ $formation->date_formatee }}</span>
                        </div>
                        <div class="flex items-center text-gray-600 dark:text-gray-400 text-sm">
                            <i class="fas fa-user mr-2"></i>
                            <span>{{ $formation->formateur->nom }}</span>
                        </div>
                    </div>
                    
                    <!-- Status Badge -->
                    @if($formation->peutEtreInscrit())
                        <span class="badge badge-success">Disponible</span>
                    @elseif($formation->estComplete())
                        <span class="badge badge-warning">Complet</span>
                    @else
                        <span class="badge badge-danger">Fermé</span>
                    @endif
                </div>
                
                <!-- Formation Description -->
                <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 line-clamp-3">{{ $formation->description }}</p>
                
                <!-- Formation Details -->
                <div class="grid grid-cols-2 gap-4 mb-4 text-sm">
                    <div class="flex items-center text-gray-500 dark:text-gray-400">
                        <i class="fas fa-clock mr-2"></i>
                        <span>{{ $formation->duree_formatee }}</span>
                    </div>
                    <div class="flex items-center text-gray-500 dark:text-gray-400">
                        <i class="fas fa-users mr-2"></i>
                        <span>{{ $formation->getNombreInscriptions() }}/{{ $formation->capacite_max }}</span>
                    </div>
                    <div class="flex items-center text-gray-500 dark:text-gray-400">
                        <i class="fas fa-signal mr-2"></i>
                        <span class="capitalize">{{ $formation->niveau ?? 'Débutant' }}</span>
                    </div>
                    <div class="flex items-center text-gray-500 dark:text-gray-400">
                        <i class="fas fa-check-circle mr-2"></i>
                        <span class="badge {{ $formation->statut == 'ACTIVE' ? 'badge-success' : 'badge-warning' }}">
                            {{ $formation->statut_libelle }}
                        </span>
                    </div>
                </div>
                
                <!-- Progress Bar -->
                <div class="mb-4">
                    <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400 mb-1">
                        <span>Places occupées</span>
                        <span>{{ $formation->progression }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                        <div class="bg-gradient-to-r from-blue-500 to-emerald-500 h-2 rounded-full transition-all duration-300" 
                             style="width: {{ $formation->progression }}%"></div>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex items-center space-x-2">
                    <a href="{{ route('formations.show', $formation) }}" 
                       class="flex-1 text-center py-2 px-4 border border-blue-600 text-blue-600 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors">
                        <i class="fas fa-eye mr-1"></i>Détails
                    </a>
                    
                    @if($formation->peutEtreInscrit() && !Auth::user()->formationsInscrites->contains($formation->id))
                        <form action="{{ route('inscriptions.store', $formation) }}" method="POST" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full btn-primary py-2 px-4 rounded-lg">
                                <i class="fas fa-plus mr-1"></i>S'inscrire
                            </button>
                        </form>
                    @elseif(Auth::user()->formationsInscrites->contains($formation->id))
                        <button disabled class="flex-1 py-2 px-4 bg-emerald-100 text-emerald-700 rounded-lg cursor-not-allowed">
                            <i class="fas fa-check mr-1"></i>Inscrit(e)
                        </button>
                    @else
                        <button disabled class="flex-1 py-2 px-4 bg-gray-300 text-gray-500 rounded-lg cursor-not-allowed">
                            <i class="fas fa-times mr-1"></i>Non disponible
                        </button>
                    @endif
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <i class="fas fa-search text-4xl text-gray-400 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Aucune formation disponible</h3>
                <p class="text-gray-600 dark:text-gray-400">Il n'y a pas de formations disponibles pour le moment</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Fuzzy matching function for close names
    function fuzzyMatch(str1, str2, threshold = 0.7) {
        // Calculate Levenshtein distance ratio
        const longer = str1.length > str2.length ? str1 : str2;
        const shorter = str1.length > str2.length ? str2 : str1;
        
        if (longer.length === 0) return 1.0;
        
        const editDistance = levenshteinDistance(longer, shorter);
        return (longer.length - editDistance) / longer.length >= threshold;
    }
    
    function levenshteinDistance(str1, str2) {
        const matrix = [];
        
        for (let i = 0; i <= str2.length; i++) {
            matrix[i] = [i];
        }
        
        for (let j = 0; j <= str1.length; j++) {
            matrix[0][j] = j;
        }
        
        for (let i = 1; i <= str2.length; i++) {
            for (let j = 1; j <= str1.length; j++) {
                if (str2.charAt(i - 1) === str1.charAt(j - 1)) {
                    matrix[i][j] = matrix[i - 1][j - 1];
                } else {
                    matrix[i][j] = Math.min(
                        matrix[i - 1][j - 1] + 1,
                        matrix[i][j - 1] + 1,
                        matrix[i - 1][j] + 1
                    );
                }
            }
        }
        
        return matrix[str2.length][str1.length];
    }
    
    // Additional helper for similar sounding names
    function soundsLike(str1, str2) {
        // Simple phonetic matching for common French/Arabic name patterns
        const phonetic1 = str1.replace(/ph/g, 'f').replace(/k/g, 'c').replace(/y/g, 'i');
        const phonetic2 = str2.replace(/ph/g, 'f').replace(/k/g, 'c').replace(/y/g, 'i');
        
        return fuzzyMatch(phonetic1, phonetic2, 0.8);
    }
    
    // Filter and search functionality
    document.getElementById('search-formation').addEventListener('input', filterFormations);
    document.getElementById('filter-niveau').addEventListener('change', filterFormations);
    document.getElementById('filter-status').addEventListener('change', filterFormations);
    
    function filterFormations() {
        const searchTerm = document.getElementById('search-formation').value.toLowerCase();
        const niveauFilter = document.getElementById('filter-niveau').value;
        const statusFilter = document.getElementById('filter-status').value;
        const cards = document.querySelectorAll('.formation-card');
        
        cards.forEach(card => {
            let showCard = true;
            
            // Search by formation name with fuzzy matching
            if (searchTerm) {
                const formationTitle = card.querySelector('h3').textContent.toLowerCase();
                const formateurName = card.querySelector('.fas.fa-user').nextElementSibling.textContent.toLowerCase();
                
                // Check for exact matches first
                let isMatch = formationTitle.includes(searchTerm) || formateurName.includes(searchTerm);
                
                // If no exact match, try fuzzy matching
                if (!isMatch) {
                    isMatch = fuzzyMatch(formationTitle, searchTerm) || 
                             fuzzyMatch(formateurName, searchTerm) ||
                             soundsLike(formateurName, searchTerm);
                }
                
                // Also check individual words
                if (!isMatch) {
                    const searchWords = searchTerm.split(' ').filter(word => word.length > 1);
                    const titleWords = formationTitle.split(' ');
                    const formateurWords = formateurName.split(' ');
                    
                    isMatch = searchWords.some(searchWord => 
                        titleWords.some(titleWord => 
                            titleWord.includes(searchWord) || 
                            fuzzyMatch(titleWord, searchWord) ||
                            soundsLike(titleWord, searchWord)
                        ) ||
                        formateurWords.some(formateurWord => 
                            formateurWord.includes(searchWord) || 
                            fuzzyMatch(formateurWord, searchWord) ||
                            soundsLike(formateurWord, searchWord)
                        )
                    );
                }
                
                if (!isMatch) {
                    showCard = false;
                }
            }
            
            // Filter by niveau
            if (niveauFilter && card.dataset.niveau !== niveauFilter) {
                showCard = false;
            }
            
            // Filter by status
            if (statusFilter === 'ACTIVE' && !card.querySelector('.badge-success')) {
                showCard = false;
            } else if (statusFilter === 'available' && card.dataset.status !== 'available') {
                showCard = false;
            }
            
            // Show/hide card
            if (showCard) {
                card.style.display = 'block';
                card.classList.remove('hidden');
            } else {
                card.style.display = 'none';
                card.classList.add('hidden');
            }
        });
        
        // Show "no results" message if no cards are visible
        updateNoResultsMessage();
    }
    
    function updateNoResultsMessage() {
        const visibleCards = document.querySelectorAll('.formation-card:not([style*="display: none"])');
        const grid = document.getElementById('formations-grid');
        let noResultsMsg = document.getElementById('no-results-message');
        
        if (visibleCards.length === 0) {
            if (!noResultsMsg) {
                noResultsMsg = document.createElement('div');
                noResultsMsg.id = 'no-results-message';
                noResultsMsg.className = 'col-span-full text-center py-12';
                noResultsMsg.innerHTML = `
                    <i class="fas fa-search text-4xl text-gray-400 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Aucun résultat trouvé</h3>
                    <p class="text-gray-600 dark:text-gray-400">Essayez de modifier vos critères de recherche</p>
                `;
                grid.appendChild(noResultsMsg);
            }
            noResultsMsg.style.display = 'block';
        } else if (noResultsMsg) {
            noResultsMsg.style.display = 'none';
        }
    }
</script>
@endsection