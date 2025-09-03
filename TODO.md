Create Separate Page for Interview Scheduling and Interviews

Plan:
- Create a new view `resources/views/candidates/interviews.blade.php` for managing interviews
- Add an `index` method to `InterviewController` to display the interviews page
- Add a new route for `candidates/{candidate}/interviews` to show the interviews page
- Move the interview scheduling form and list from `show.blade.php` to the new interviews page
- Update `show.blade.php` to show only a summary of interviews with a link to the full interviews page
- Keep the interview update functionality in the show page for quick updates

Dependent Files:
- resources/views/candidates/interviews.blade.php (new)
- app/Http/Controllers/InterviewController.php (updated)
- routes/web.php (updated)
- resources/views/candidates/show.blade.php (updated)

Followup Steps:
- Test the new interviews page for scheduling and managing interviews
- Verify the link from show page to interviews page works correctly
- Ensure interview updates still work from the show page summary
- Check that the email reminder functionality still works
