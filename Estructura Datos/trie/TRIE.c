#include <stdio.h>
#include <stdlib.h>
#include <SDL/SDL.h>
#include <SDL/SDL_image.h>
#include <SDL/SDL_ttf.h>
#define ancho 1000       
#define alto 700
#define MAX 3
typedef struct nodo
{       struct nodo *nodos[MAX];
        int prefijo;
        int palabra;
	SDL_Rect posicion;
}NODO;
typedef NODO TRIE;

SDL_Surface *screen,*instrucciones_img,*acerca_img,*ufo,*barra_img,*seguro_img,*mini_ventana,*alerta,*fondo,*img_NULL,*FLECHA[4][3],*aviso_img,*menu_img;
TTF_Font *mini_font2,*font_numeros,*font_null,*mini_font,*robofont,*bigfont,*aviso_font; 
SDL_Color color_azul,color_blanco,color_negro;


void Load_image(SDL_Surface **image,char *ptr);
int posicion_cursor(int xi,int xf,int yi,int yf,int mousex,int mousey);
void cargando_interface();
void interface_principal();
void pintar_ruta(TRIE T,char *ptr);
int nulo(TRIE T);
void ventana_buscar(TRIE *T);
void ventana_buscar(TRIE *T);
void ventana_insertar(TRIE *T);
void pintar_arreglo(TRIE T,int nivel);
void pintar_flecha(int x,int y,int opcion);
int ventana_seguro();
void ecuacion_recta(int x1,int y1,int x2,int y2);
void ventana_alerta(char *ptr);
void calcular_posiciones(TRIE *T,int x,int y,int n,int op);
void barra_buscadora(TRIE T);
void ventana_acerca();
void ventana_instrucciones();

int buscar(TRIE T,char *ptr);
void inicializar(TRIE *T);
void insertar(TRIE *T,char *ptr);
int cantidad_palabras(TRIE T);
void print_on_screen(char c[],int x,int y,SDL_Color color,TTF_Font *fonti);
void menu(TRIE *T);
int main(int argc, char *argv[])
{       //inicializando SDL
        if(SDL_Init(SDL_INIT_VIDEO)<0)
        {       printf("Error al establecer modo video\n");exit(1);}
        SDL_WM_SetCaption("TRIE","FILES/imagenes/icono.png");
        screen=SDL_SetVideoMode(ancho,alto,24,SDL_SWSURFACE);
        if(screen==NULL)
        {       printf("No se establecio el modo de video\n");
                exit(1);
        }       
        //font
        TTF_Init();
	cargando_interface();
//programa principal
	TRIE T;
	inicializar(&T);
	
	SDL_Rect pos,posufo;
	pos.x=0;pos.y=0;
	SDL_BlitSurface(menu_img,NULL,screen,&pos);
	posufo.y=15;
	int N=1;
	SDL_Flip(screen);
	SDL_Event evento;
	while(N)
	{	SDL_WaitEvent(&evento);
		if(evento.type==SDL_MOUSEMOTION)
                {       if(posicion_cursor(266,760,36,142,evento.motion.x,evento.motion.y))
			{	SDL_BlitSurface(menu_img,NULL,screen,&pos);
			        posufo.x=100; posufo.y=15;
			        SDL_BlitSurface(ufo,NULL,screen,&posufo);
				SDL_Flip(screen);	
			}
			else if(posicion_cursor(266,760,179,287,evento.motion.x,evento.motion.y))
			{       SDL_BlitSurface(menu_img,NULL,screen,&pos);
                                posufo.x=100; posufo.y=160;
                                SDL_BlitSurface(ufo,NULL,screen,&posufo);       
                                SDL_Flip(screen);
                        }
			else if(posicion_cursor(266,760,327,436,evento.motion.x,evento.motion.y))
			{       SDL_BlitSurface(menu_img,NULL,screen,&pos);
                                posufo.x=100; posufo.y=312;
                                SDL_BlitSurface(ufo,NULL,screen,&posufo);
                                SDL_Flip(screen);
                        }
			else if(posicion_cursor(266,760,437,582,evento.motion.x,evento.motion.y))
			{       SDL_BlitSurface(menu_img,NULL,screen,&pos);
                                posufo.x=100; posufo.y=460;
                                SDL_BlitSurface(ufo,NULL,screen,&posufo);
                                SDL_Flip(screen);
                        }
		}
		if(evento.type==SDL_MOUSEBUTTONDOWN)
                {       if(posicion_cursor(266,760,36,142,evento.button.x,evento.button.y))
			{	menu(&T);}
			else if(posicion_cursor(266,760,179,287,evento.button.x,evento.button.y))
			{	ventana_instrucciones();
                                SDL_BlitSurface(menu_img,NULL,screen,&pos);
                                SDL_Flip(screen);
			}
			else if(posicion_cursor(266,760,327,436,evento.button.x,evento.button.y))
			{	ventana_acerca();	
				SDL_BlitSurface(menu_img,NULL,screen,&pos);
				SDL_Flip(screen);
			}
			else if(posicion_cursor(266,760,437,582,evento.button.x,evento.button.y))
				N=0;
		}
	}
	//menu(&T);
	SDL_FreeSurface(screen);	
	SDL_Quit();
	return 0;
}
void menu(TRIE *T)
{	interface_principal();
	SDL_Flip(screen);
	
	SDL_Event evento;
	while(1)
	{	SDL_WaitEvent(&evento);
                if(evento.type==SDL_MOUSEBUTTONDOWN)
                {       if(posicion_cursor(197,315,12,47,evento.button.x,evento.button.y)) 
			{	ventana_insertar(T);
				interface_principal();
				calcular_posiciones(T,440,100,900,0);
				if(cantidad_palabras(*T)>0)
					pintar_arreglo(*T,0);
			        SDL_Flip(screen);
			}
			else if(posicion_cursor(858,982,12,47,evento.button.x,evento.button.y))
			{	SDL_FreeSurface(screen);
				SDL_Quit();	
				exit(1);
			}
			else if(posicion_cursor(51,186,20,40,evento.button.x,evento.button.y))
                        {       barra_buscadora(*T);
				interface_principal();
                                if(cantidad_palabras(*T)>0)
                                        pintar_arreglo(*T,0);
                                SDL_Flip(screen);
                        }
			else if(posicion_cursor(320,433,12,47,evento.button.x,evento.button.y))
			{	char C[100];
				int n=cantidad_palabras(*T);
				if(n==0)
				{	sprintf(C,"No existen palabras");}
				else if(n==1)
				{	sprintf(C,"Existe 1 palabra");}
				else
				{	sprintf(C,"Existen %d palabras",n);}
				ventana_alerta(&C[0]);
				if(n>0)
				{	pintar_arreglo(*T,0);
                                	SDL_Flip(screen);
				}
					
			}
			else if(posicion_cursor(440,539,12,47,evento.button.x,evento.button.y))
			{	if(cantidad_palabras(*T)==0)
					ventana_alerta("No existen palabras");
				else{
					ventana_buscar(T);
					interface_principal();
                	                if(cantidad_palabras(*T)>0)
                        	                pintar_arreglo(*T,0);
                               		 SDL_Flip(screen);
				}
			}	
			else if(posicion_cursor(546,728,12,47,evento.button.x,evento.button.y))
			{	if(cantidad_palabras(*T)==0)
				{	ventana_alerta("No existen palabras");}
				else{
					int n=ventana_seguro();
					if(n)
					{	inicializar(T);
						interface_principal();
					        SDL_Flip(screen);
					}
					else
					{	interface_principal();
						if(cantidad_palabras(*T))
							pintar_arreglo(*T,0);
        					SDL_Flip(screen);
					}
				}		
			}
			else if(posicion_cursor(734,852,12,47,evento.button.x,evento.button.y))
				return;
				
		}
		
	}
	
}
void barra_buscadora(TRIE T)
{	SDL_Rect pos={51,20,186-51,20};
	SDL_FillRect(screen,&pos,SDL_MapRGBA(screen->format,62,68,84,100));
	SDL_Flip(screen);
	SDL_Event evento;
        int i=0;
        char cad[4],C[100];cad[i]='\0';
        while(1)
        {       SDL_WaitEvent(&evento);
                if(evento.type==SDL_KEYDOWN)
                {       if(i<3)
                                switch(evento.key.keysym.sym)
                                {       case SDLK_a:
                                                cad[i++]='a';
                                                cad[i]='\0';
                                                break;
                                        case SDLK_b:
                                                cad[i++]='b';
                                                cad[i]='\0';
                                                break;
                                        case SDLK_c:
                                                cad[i++]='c';
                                                cad[i]='\0';
                                                break;

                                }
                        if(evento.key.keysym.sym==8 && i>0)
                        {       i--; cad[i]='\0';}
                        if(evento.key.keysym.sym==SDLK_RETURN)
                        {       cad[i]='\0';break;}
                        if(evento.key.keysym.sym==27)
                                return;
                        SDL_FillRect(screen,&pos,SDL_MapRGBA(screen->format,62,68,84,100));
			sprintf(C," %s  [enter]",cad);
                        print_on_screen(&C[0],51,17,color_blanco,mini_font2);
                        SDL_Flip(screen);
                }
		if(evento.type==SDL_MOUSEBUTTONDOWN)
			return;
	}
	 if(cad[0]!='\0')
                if(buscar(T,&cad[0]))
                {       interface_principal();
                        pintar_arreglo(T,0);
                        SDL_Flip(screen);
                        pintar_ruta(T,&cad[0]);}

}
int ventana_seguro()
{	SDL_Rect pos={0,0,700,900};
	SDL_BlitSurface(seguro_img,NULL,screen,&pos);
	print_on_screen("  Desea borrar todo ?",355,265,color_blanco,aviso_font);
	SDL_Flip(screen);	
	SDL_Event evento;
	while(1)
	{	SDL_WaitEvent(&evento);
		 SDL_WaitEvent(&evento);
                 if(evento.type==SDL_KEYDOWN)
                 {      if(evento.key.keysym.sym==SDLK_RETURN)
                                return 1;
                        else if(evento.key.keysym.sym==27)
                                return 0;
                }
                else if(evento.type==SDL_MOUSEBUTTONDOWN)
                {       if(posicion_cursor(412,477,326,348,evento.button.x,evento.button.y))
                                return 1;
			if(posicion_cursor(521,587,326,348,evento.button.x,evento.button.y))
				return 0;
                }
	}
	
}
void ventana_alerta(char *ptr)
{	SDL_Rect pos={0,0,900,700};
	SDL_BlitSurface(alerta,NULL,screen,&pos);
	print_on_screen(ptr,355,265,color_blanco,aviso_font);
	SDL_Flip(screen);
	SDL_Event evento;	
	while(1)
	{
		SDL_WaitEvent(&evento);
		 if(evento.type==SDL_KEYDOWN)
                 {	if(evento.key.keysym.sym==SDLK_RETURN)
				break;
			else if(evento.key.keysym.sym==27)
				break;
		}
		else if(evento.type==SDL_MOUSEBUTTONDOWN)
                {       if(posicion_cursor(451,546,330,352,evento.button.x,evento.button.y))
				break;
		}
	}
	interface_principal();
	SDL_Flip(screen);
}
void ventana_buscar(TRIE *T)
{       SDL_Rect pos;
        char c[100];
        pos.x=0;pos.y=0;
        SDL_BlitSurface(mini_ventana,NULL,screen,&pos);
        sprintf(c," Buscar palabra.");
        print_on_screen(&c[0],390,245,color_blanco,robofont);
        SDL_Flip(screen);
        SDL_Event evento;
        int i=0;
        char cad[4];cad[i]='\0';
        while(1)
        {       SDL_WaitEvent(&evento);
                if(evento.type==SDL_KEYDOWN)
                {       if(i<3)
                                switch(evento.key.keysym.sym)
                                {       case SDLK_a:
                                                cad[i++]='a';
                                                cad[i]='\0';
                                                break;
                                        case SDLK_b:
                                                cad[i++]='b';
                                                cad[i]='\0';
                                                break;
                                        case SDLK_c:
                                                cad[i++]='c';
                                                cad[i]='\0';
                                                break;

                                }
                        if(evento.key.keysym.sym==8 && i>0)
                        {       i--; cad[i]='\0';}
                        if(evento.key.keysym.sym==SDLK_RETURN)
                        {       cad[i]='\0';break;}
                        if(evento.key.keysym.sym==27)
                                return;
                        SDL_Rect rectangulo={410,281,180,62};
                        SDL_FillRect(screen,&rectangulo,SDL_MapRGBA(screen->format,255,255,255,100));
                        print_on_screen(&cad[0],420,268,color_negro,bigfont);
                        SDL_Flip(screen);
                }
                else if(evento.type==SDL_MOUSEBUTTONDOWN)
                {       if(posicion_cursor(387,462,379,399,evento.button.x,evento.button.y))
                                break;
			 if(posicion_cursor(540,613,379,399,evento.button.x,evento.button.y))
                                return;
                }

        }
        if(cad[0]!='\0')
		if(buscar(*T,&cad[0]))
		{	interface_principal();
                        pintar_arreglo(*T,0);
			SDL_Flip(screen);
			pintar_ruta(*T,&cad[0]);}
		else
		{	char P[100];
			sprintf(P,"la palabra no existe");
			ventana_alerta(&P[0]);
		}
		
}
void pintar_ruta(TRIE T,char *ptr)
{	if(*ptr=='\0')
	{	SDL_Delay(400);
		return;
	}
	int n=*ptr-'a';
	SDL_Rect rect={T.posicion.x+(n*26),T.posicion.y+50,26,50};
	SDL_FillRect(screen,&rect,SDL_MapRGBA(screen->format,58,64,77,100));
	char c[2];
	switch(n)
	{	case 0:
			c[0]='a';
			break;
		case 1:
			c[0]='b';
			break;
		case 2:	
			c[0]='c';
			break;
	}
	c[1]='\0';
	int x=T.posicion.x+(n*26),y=T.posicion.y+43;
	print_on_screen(&c[0],x+3,y,color_azul,font_numeros);
	SDL_Flip(screen);
	SDL_Delay(450);
	pintar_ruta(*(T.nodos[n]),ptr+1);
}
void ventana_insertar(TRIE *T)
{	SDL_Rect pos;
	char c[100];
	pos.x=0;pos.y=0;
	SDL_BlitSurface(mini_ventana,NULL,screen,&pos);
	sprintf(c,"Insertar palabra.");
	print_on_screen(&c[0],390,245,color_blanco,robofont);
	SDL_Flip(screen);	
	SDL_Event evento;
	int i=0;
	char cad[4];cad[i]='\0';
	while(1)
	{	SDL_WaitEvent(&evento);
		if(evento.type==SDL_KEYDOWN)
                {       if(i<3)
				switch(evento.key.keysym.sym)
				{	case SDLK_a:
						cad[i++]='a';
						cad[i]='\0';
						break;
					case SDLK_b:
						cad[i++]='b';
						cad[i]='\0';
						break;
					case SDLK_c:	
						cad[i++]='c';
						cad[i]='\0';
						break;
					
				}
			if(evento.key.keysym.sym==8 && i>0)
			{	i--; cad[i]='\0';}
			if(evento.key.keysym.sym==SDLK_RETURN)
                        {       cad[i]='\0';break;}
			if(evento.key.keysym.sym==27)
				return;
			SDL_Rect rectangulo={410,281,180,62};
			SDL_FillRect(screen,&rectangulo,SDL_MapRGBA(screen->format,255,255,255,100));
			print_on_screen(&cad[0],420,268,color_negro,bigfont);
			SDL_Flip(screen);
		}
		else if(evento.type==SDL_MOUSEBUTTONDOWN)
                {       if(posicion_cursor(387,462,379,399,evento.button.x,evento.button.y))
				break;
			if(posicion_cursor(540,613,379,399,evento.button.x,evento.button.y))
                                return;
		}
	
	}
	if(cad[0]!='\0')
		insertar(T,&cad[0]);
		
}
void pintar_arreglo(TRIE T,int nivel)
{       int i;
        char c[20];
        if(nulo(T))
        {       SDL_Rect cuadro={(T.posicion).x+20,(T.posicion).y,30,70};
                SDL_FillRect(screen,&cuadro,SDL_MapRGBA(screen->format,0,0,0,100));
                sprintf(c,"pal=%d",T.palabra);
                print_on_screen(&c[0],(T.posicion).x+20,(T.posicion).y,color_blanco,mini_font);
                SDL_Rect posi;
                posi.x=cuadro.x;posi.y=cuadro.y+16;
                SDL_BlitSurface(img_NULL,NULL,screen,&posi);
        }
        else
        {
                SDL_Rect rec={(T.posicion).x,(T.posicion).y,80,100};
                SDL_FillRect(screen,&rec,SDL_MapRGBA(screen->format,58,64,77,100));
                rec.y+=50;rec.w=80; rec.h=50;
                sprintf(c,"prefijo=%d",T.prefijo);
                print_on_screen(&c[0],(T.posicion).x,(T.posicion).y,color_blanco,font_null);
                sprintf(c,"palabra=%d",T.palabra);
                print_on_screen(&c[0],(T.posicion).x,(T.posicion).y+22,color_blanco,font_null);

                SDL_FillRect(screen,&rec,SDL_MapRGBA(screen->format,0,0,0,100));
                rec.x=(T.posicion).x+26;
                rec.w=2;
                SDL_FillRect(screen,&rec,SDL_MapRGBA(screen->format,58,64,77,100));
                rec.x+=26;
                SDL_FillRect(screen,&rec,SDL_MapRGBA(screen->format,58,64,77,100));
                int x=(T.posicion).x,y=(T.posicion).y+43;
		SDL_Rect posf;posf.x=x+10; posf.y=y+50;
                for(i=0; i<MAX;i++,x+=26)
                {       if(T.nodos[i]!=NULL)
                        {       switch(i)
                                {       case 0:
                                                sprintf(c,"a");
						posf.x+=i*26;
						posf.x-=FLECHA[nivel][0]->w;
						posf.x+=10;
						SDL_BlitSurface(FLECHA[nivel][0],NULL,screen,&posf);
                                                break;
                                        case 1:
                                                sprintf(c,"b");
						posf.x=T.posicion.x+i*26;
						posf.x+=5;
                                                SDL_BlitSurface(FLECHA[nivel][1],NULL,screen,&posf);
                                                break;
                                        case 2:
                                                sprintf(c,"c");
						posf.x=T.posicion.x+i*26+5;
                                                SDL_BlitSurface(FLECHA[nivel][2],NULL,screen,&posf);
                                                break;
                                }
                                print_on_screen(&c[0],x+3,y,color_azul,font_numeros);
                                pintar_arreglo(*T.nodos[i],nivel+1);
                        }
                        else 
                        {       SDL_Rect posi;
                                posi.x=x;posi.y=y+7;
                                SDL_BlitSurface(img_NULL,NULL,screen,&posi);
                        }
                        
                }
        }
}
int cantidad_palabras(TRIE T)
{       return T.prefijo;
}
void insertar(TRIE *T,char *ptr)
{       if(*ptr=='\0')
        {       T->palabra++;
                return;
        }
        T->prefijo++;
        int n=*ptr-'a';
        if(T->nodos[n]==NULL)
        {       T->nodos[n]=(struct nodo *)malloc(sizeof(NODO));
                inicializar(T->nodos[n]);
                
        }
        insertar(T->nodos[n],ptr+1);
}
void inicializar(TRIE *T)
{	(T->posicion).x=0;
	(T->posicion).y=0;
	T->prefijo=0;
	T->palabra=0;
	int i;
	for(i=0; i<MAX; i++)
		T->nodos[i]=NULL;
}
void interface_principal()
{	SDL_Rect pos; pos.x=0; pos.y=0; 
	SDL_BlitSurface(fondo,NULL,screen,&pos);
}
void calcular_posiciones(TRIE *T,int x,int y,int n,int op)
{	if(T==NULL)
		return;
	if(op==0)
	{	T->posicion.x=480;
		T->posicion.y=y;
	}
	else
	{	T->posicion.x=x;
		T->posicion.y=y;
	}
	int norma=n/3,i;
	for(i=0; i<MAX; i++)
		if(T->nodos[i]!=NULL)
			switch(i)
			{	case 0:
					calcular_posiciones(T->nodos[i],T->posicion.x-norma,y+150,norma,1);
					break;
				case 1:
					calcular_posiciones(T->nodos[i],T->posicion.x,y+150,norma,1);
					break;
				case 2:
					calcular_posiciones(T->nodos[i],T->posicion.x+norma,y+150,norma,1);
					break;
			}

}
void ecuacion_recta(int x1,int y1,int x2,int y2)
{      
      if(y1>y2)
        {       int temp=x1;
                x1=x2; x2=temp;
                temp=y1; y1=y2; y2=temp;
        }
	if(x1>x2)
        {       int temp=x1;
                x1=x2; x2=temp;
                temp=y1; y1=y2; y2=temp;
        }
        if(x1==x2 && y1==y2)
                return;
        if(x1==x2)
        {       SDL_Rect p={x1,y1,2,y2-y1};
                SDL_FillRect(screen,&p,SDL_MapRGBA(screen->format,255,255,255,100));
        }
        else{
                int m=(y1-y2)/(x1-x2),b=y1-(m*x1);
                float x=x1;
                SDL_Rect p;
                p.w=2;p.h=2;
                for( ; x<=x2; x+=0.01)
                {       p.x=x;
                         p.y=(m*x)+b;
                        SDL_FillRect(screen,&p,SDL_MapRGBA(screen->format,255,255,255,100));
                }
	}
}
int nulo(TRIE T)
{	int i;
	for(i=0; i<MAX; i++)
		if(T.nodos[i]!=NULL)
			return 0;
	return 1;
}
void cargando_interface()
{	font_numeros=TTF_OpenFont("FILES/fonts/fuente_letras.ttf",50);
	if(font_numeros==NULL)
		printf("ERROR FALTA fuente_letras.ttf\n");
	font_null=TTF_OpenFont("FILES/fonts/NULL.ttf",18);
	if(font_null==NULL)
		printf("ERROR falta NULL.ttf\n");
	mini_font=TTF_OpenFont("FILES/fonts/NULL.ttf",13);
	if(mini_font==NULL)
		printf("Error falta NULL.ttf\n");
	mini_font2=TTF_OpenFont("FILES/fonts/NULL.ttf",19);
	if(mini_font2==NULL)
		printf("FALTA NULL.ttf");
	bigfont=TTF_OpenFont("FILES/fonts/robot.ttf",75);
	if(bigfont==NULL)
		printf("Error en robot.ttf\n");
	robofont=TTF_OpenFont("FILES/fonts/robot.ttf",30);
	if(robofont==NULL)
		printf("Error falta robot.ttf\n");
	aviso_font=TTF_OpenFont("FILES/fonts/aviso.ttf",27);
	if(aviso_font==NULL)
		printf("Error falta aviso.ttf");
	int i,j;
	char c[100];
	for(i=0; i<3; i++)
		for(j=0; j<3; j++)
		{	sprintf(c,"FILES/imagenes/flecha%d%d.png",i,j);
			Load_image(&FLECHA[i][j],&c[0]);
		}		

	
	color_blanco.r=255;color_blanco.g=255;color_blanco.b=255;
	color_azul.r=122; color_azul.g=142; color_azul.b=241;
	color_negro.r=0; color_negro.g=0; color_negro.b=0;
	Load_image(&fondo,"FILES/imagenes/fondo.jpg");
	Load_image(&seguro_img,"FILES/imagenes/seguro.png");
	Load_image(&alerta,"FILES/imagenes/alerta.png");
	Load_image(&img_NULL,"FILES/imagenes/null.png");
	Load_image(&mini_ventana,"FILES/imagenes/mini_ventana.png");
	Load_image(&ufo,"FILES/imagenes/ufo.png");
	Load_image(&menu_img,"FILES/imagenes/menu.png");
	Load_image(&acerca_img,"FILES/imagenes/acercade.png");
	Load_image(&barra_img,"FILES/imagenes/barra.png");	
	Load_image(&instrucciones_img,"FILES/imagenes/instrucciones.jpg");
}
void print_on_screen(char *c,int x,int y,SDL_Color color,TTF_Font *fonti)
{       SDL_Rect pos;
        pos.x=x; pos.y=y;
        SDL_Surface *letras;
        letras=TTF_RenderText_Solid(fonti,c,color);
        SDL_BlitSurface(letras,NULL,screen,&pos);
}
void Load_image(SDL_Surface **image,char *ptr)
{       *image=IMG_Load(ptr);
        if(*image==NULL)
               printf("Error no se cargo %s\n ",ptr);
       
}
int posicion_cursor(int xi,int xf,int yi,int yf,int mousex,int mousey)
{       if(mousex>=xi && mousex<=xf && mousey>=yi && mousey<=yf)
                return 1;
        return 0;
}
int buscar(TRIE T,char *ptr)
{       if(*ptr=='\0')
                return T.palabra;
        int n=*ptr-'a';
        if(T.nodos[n]==NULL)
                return 0;
        return buscar(*(T.nodos[n]),ptr+1);
}
void ventana_acerca()
{	SDL_Rect pos;
	pos.x=0; pos.y=0;
	SDL_BlitSurface(acerca_img,NULL,screen,&pos);
	SDL_Flip(screen);
	SDL_Event evento;
	while(1)
	{	SDL_WaitEvent(&evento);
		if(evento.key.keysym.sym==SDLK_RETURN)
                 	return;
                if(evento.key.keysym.sym==27)
			return;
	}
}
void ventana_instrucciones()
{
	SDL_Rect pos;
        pos.x=0; pos.y=0;
        SDL_BlitSurface(instrucciones_img,NULL,screen,&pos);
        SDL_Flip(screen);
        SDL_Event evento;
        while(1)
        {       SDL_WaitEvent(&evento);
                if(evento.key.keysym.sym==SDLK_RETURN)
                        return;
                if(evento.key.keysym.sym==27)
                        return;
        }
}
