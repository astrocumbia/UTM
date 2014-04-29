#include <iostream>
#include <SDL/SDL.h>
#include <SDL/SDL_image.h>
#include <SDL/SDL_ttf.h>
#include <cmath>
#include "libs/Screen.cpp"
#include "libs/Point.cpp"
#include "libs/Polygon2D.cpp"
#include "telefono.h"

using namespace std;
int app = 0;

void draw( ){
	
	pantalla.fillPolygon( screen, 0xffffff );
	mostrar_boton_home( );

	if( app == 0 ){
		mostrar_wallpaper( );
		mostrar_widgets( );
		app_mensajes( );
	}
	if( app == 1 ){
		APP_RELOJ( );
	}
	if( app == 2 ){
		APP_NOTAS( );
	}
	if( app==3 ){
		APP_TWITTER( );
	}
	if( app == 4 ){
		APP_TELEFONO( );
	}
	mostrar_barra_superior( );

	
	
	screen.update( );


}

int main( ){
	

	init_( );
	int done = 0;
    while (!done)
    {
        SDL_Event event;

        /* Check for events */
        while (SDL_PollEvent (&event))
        {	
        	int X = event.motion.x;
        	int Y = event.motion.y;        	
        	if( event.type == SDL_MOUSEBUTTONDOWN && getDistancia(X,Y-1-780,260,25) <= 55 ){
				app = 0;
    			break;
    		}
    		if( event.type == SDL_MOUSEBUTTONDOWN && app == 4 ){
            	int X = event.motion.x;
            	int Y = event.motion.y;
            	if( llamar == 1){
	            	if( X>=31 && X<=464 && Y>=653  && Y<=719 ){
			            llamar = 0;
			            break;
	            	}              		
            	}
            	//cout<<"--> "<<X<<" "<<Y<<endl;
    			if( X>=428 && X<=479 && Y>=80 && Y<=133 ){
		            POPNUM( );	
            		break;
            	}
    			if( X>=31 && X<=146 && Y>=180 && Y<=257 ){
		            pushNUM("1");		
            		break;
            	}
    			if( X>=190 && X<=305 && Y>=180 && Y<=257 ){
		            pushNUM("2");		
            		break;
            	}	            		
    			if( X>=351 && X<=468 && Y>=180 && Y<=257 ){
		            pushNUM("3");		
            		break;
            	}
    			if( X>=31 && X<=146 && Y>=301 && Y<=377 ){
		            pushNUM("4");		
            		break;
            	}   
    			if( X>=190 && X<=305 && Y>=301 && Y<=377 ){
		            pushNUM("5");		
            		break;
            	}
            	if( X>=351 && X<=468 && Y>=301 && Y<=377 ){
		            pushNUM("6");		
            		break;
            	}  
    			if( X>=31 && X<=146 && Y>=421 && Y<=503 ){
		            pushNUM("7");		
            		break;
            	}     
    			if( X>=190 && X<=305 && Y>=421 && Y<=503 ){
		            pushNUM("8");		
            		break;
            	}
            	if( X>=351 && X<=468 && Y>=421 && Y<=503 ){
		            pushNUM("9");		
            		break;
            	} 	            	       	          	    
   				if( X>=31 && X<=146 && Y>=541 && Y<=618 ){
		            pushNUM("*");		
            		break;
            	} 
    			if( X>=190 && X<=305 && Y>=541 && Y<=618 ){
		            pushNUM("0");		
            		break;
            	}
            	if( X>=351 && X<=468 && Y>=541 && Y<=618 ){
		            pushNUM("#");		
            		break;
            	}            	              	
            	if( X>=31 && X<=464 && Y>=653  && Y<=719 ){
		            if( NUM[0]=='\0' )
		            	break;
		            llamar = 1;
		            //cout<<"LLAMAR"<<endl;		
            		break;
            	}  
    		}
		    if( event.type == SDL_QUIT){
                done = 1;
            	break;	
		    }       	
        	if( app == 0 ){
	            switch (event.type)
	            {
		            case SDL_KEYDOWN:
		                break;
		            case SDL_QUIT:
		                done = 1;
		            	break;
		            case SDL_MOUSEBUTTONDOWN:{
		            	
		            	int X = event.motion.x;
		            	int Y = event.motion.y;

		            	if( X>=48 && X<=144 && Y>=412 && Y<=509 ){
		            		app = 1;
		            		break;
		            	}
		            	if( X>=351 && X<=446 && Y>=229 && Y<=327 ){
		            		app = 2;
		            	//	cout << "Estas en notas \n";
		            	}
		            	if( X>=49 && X<=147 && Y>=228 && Y<=326 ){
		            		app = 3;
		            		break;
		            	}
		            	if( X>=201 && X<=298 && Y>=230 && Y<=329 ){
		            		app = 4;
		            		initNUM( );
		            		llamar = 0;
		            		break;
		            	}
		            	if( getDistancia(X,Y-1-780,260,25) <= 55 ){
		            		app = 0;
		            		break;
		            	}
		            	//std::cout<<"Usted esta haciendo click en ";
		            	//std::cout<<event.motion.x<<" "<<event.motion.y<<endl;
		                break;
		             }
		            default:
		                break;
	            }
            }
        }
        SDL_Delay(70);
        draw( );
    }	

    screen.close_SDL( );
	return 0;
}
