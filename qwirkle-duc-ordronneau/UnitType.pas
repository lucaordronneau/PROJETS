(*
 ------------------------------------------------------------------------------------
 -- Fichier           : unitType
 -- Auteur            : Charles DUC <duccharles@eisti.eu>
 -- Date de creation  : 18/05/18
 --
 -- But               :
 -- Remarques         : unit qui contient tout les types
 -- Compilation       : fpc
 -- Edition des liens : fpc
 -- Execution         : shell
 ------------------------------------------------------------------------------------
 *)
Unit UnitType;

interface   
TYPE
   typeposition	= RECORD
		     x : Integer;
		     y : Integer; //mettre dans les ptr piece
		  END; 
   ptr_piece	= ^piece;
   piece	= RECORD
		     couleurs : Integer;
		     formes   : Integer;
		     suivant  : ptr_piece;
		  End;	      
   typeGrille	= array of array of ptr_piece;	      
   typeParam	= RECORD
		     j : String;
		     c : integer;
		     f : integer;
		     t : integer;
		  End; 
   typeMain	= RECORD
		     main   : ptr_piece;
		     pioche : ptr_piece;
		     piece  : piece;
		  End;	    
   typejoueurs	= RECORD     
		     age    : Integer;
		     nom    : string;
		     points : Integer;
		     main   : typeMain;
		  End;	    
   senstour	= array of typejoueurs;
   toutEnUn	= RECORD
		     main   : ptr_piece;
		     pioche : ptr_piece;
		     grille : typeGrille;
		     points : Integer;
		  End;	    
   grillepoints	= RECORD
		     grille : typegrille;
		     points : Integer;
		  End;
   
   
implementation
   


END.		    
