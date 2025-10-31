<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class CourseController extends Controller
{
    /**
     * Afficher tous les cours
     */
    public function index()
    {
        return Course::all();
    }

    /**
     * Afficher un cours spécifique
     */
    public function show(Course $course)
    {
        return $course;
    }

    /**
     * Créer un cours
     */
    public function store(Request $request)
    {
        $infos = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);

        $course = Course::create($infos);

        return response()->json([
            'message' => 'Cours ajouté avec succès',
            'course' => $course
        ], 201);
    }

    /**
     * Modifier un cours
     */
    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|max:255',
            'description' => 'sometimes|required|max:255',
        ]);

        $course->update($validated);

        return [
            'message' => 'Cours mis à jour',
            'course' => $course
        ];
    }

    /**
     * Supprimer un cours
     */
    public function destroy(Course $course)
    {
        $course->delete();

        return [
            'message' => 'Cours supprimé'
        ];
    }

    /**
     * Inscrire un étudiant à un cours
     */
    public function enroll($courseId)
    {
        $course = Course::findOrFail($courseId);
        $user = auth()->user(); // utilisateur connecté

        if ($course->students()->where('user_id', $user->id)->exists()) {
            return response()->json(['message' => 'Déjà inscrit à ce cours'], 400);
        }

        $course->students()->attach($user->id);

        return response()->json([
            'message' => 'Inscription réussie',
            'course' => $course
        ]);
    }

    /**
     * Voir les cours où l'étudiant est inscrit
     */
    public function myCourses()
    {
        $user = auth()->user();

        $courses = $user->coursesEnrolled()->with('teacher')->get();

        return response()->json($courses);
        
    }
}
