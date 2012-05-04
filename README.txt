Name:	Cameron Solomon
SID:	603 809 897
Email:	cameronjsolomon@ucla.edu

Name:	Ervin Sukardi
SID:	203 808 277
Email:	emsukardi@gmail.com

////////////////////////////////////////////////////////////////////////////////
// Project Functionality
////////////////////////////////////////////////////////////////////////////////

To our knowledge, all necessary functionality has been implemented.

Input Pages:
 - I1:	There is a page that lets users add actors and/or directors
 - I2:	There is a page that lets users submit comments for movies
 - I3:	There is a page that lets users add movies
 - I4:	There is a page that lets users add actor-movie relations, and
	a separate page that lets users add director-movie relations

Output Pages:
 - B1:	There is a page that lets users view actor information
	The page includes links to all movies the actor was in
 - B2:	There is a page that lets users view movie information
	The page also includes links to actors the movie featured, as well
	as the submitted movie reviews, and a link to add a comment to that
	particular movie

Search Page:
- S1:	There is a page that allows users to search for actors or movies.
	The query is processed such that every word (separated by spaces)
	must be part of the actor name or movie title for it to be counted
	as a result
		e.g. when searching for "Tom Hanks" as an actor, we check:
			WHILE
			(last LIKE '%Tom%' OR first LIKE '%Tom%') AND
			(last LIKE '%Hanks%' OR first LIKE '%Hanks%')

There are no additional features added, other than that the menu is visible as 
a persistent on the left side of the screen.

////////////////////////////////////////////////////////////////////////////////
// Distribution of Work
////////////////////////////////////////////////////////////////////////////////

 - Cameron Solomon
	- Basic page format
	- Adding Actors and Directors
	- Adding Movies
	- Adding Actor/Director relations
	- Browsing Movies
	- Browsing Actors

 - Ervin Sukardi
	- Searching for Actors or Movies
	- Adding Comments to movies
	- Interface tweaks and bug checking

////////////////////////////////////////////////////////////////////////////////
// Team Improvements
////////////////////////////////////////////////////////////////////////////////

In the future, I (Ervin Sukardi) feel like I should take on a larger 
distribution of work when completing the next project. However, other than this,
we seemed to be communicating what needed to be done at any given time.