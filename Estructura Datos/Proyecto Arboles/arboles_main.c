#include <stdio.h>
#include <stdlib.h>
#include <SDL/SDL.h>
#include <SDL_image.h>
#include <SDL_ttf.h>
#define ancho 900	
#define alto 675
typedef struct nodo
{	int dato;
	struct nodo *izq,*der;
	SDL_Rect pos;
}NODO;
typedef NODO *PNODO;
typedef NODO *ARBOL;
ARBOL A;
SDL_Surface *screen,*fondo,*boton_aceptar[2],*boton_cancelar[2],*boton_eliminar[2],*boton_ino[2];
SDL_Surface *boton_insertar[2],*boton_ok[2],*boton_pos[2],*boton_pre[2],*boton_recorridos[2];
SDL_Surface *boton_salir[2],*mini_window,*fondo_principal,*texto,*icon_add,*nodo_img,*icon_del,*cadena;
SDL_Surface *m_principal,*window_explicacion,*window_acerca,*window_ayuda,*nodo_visitado,*flechader[5],*window_alerta,*flechaizq[5],*img_principal,*tipos_recorridos[3][2];
SDL_Color fcolor;
TTF_Font* font,*recorrido_ttf,* font_num,*font_menu,*arbol_ttf,*font_op;
int bandera,distancia;
void imprimir_recorridos(int n);
void menu_entrada();
void ventana_acerca();
void Load_image(SDL_Surface **image,char *ptr);
void cargando_interface();
void ventana_alerta(char *ptr);
void calcular_posiciones(ARBOL A,int y, int x,int n,int op);
void draw_interface_principal();
void draw_menu_botones();
int mayor_arbol(ARBOL A);
void ventana_ayuda();
void eliminar(ARBOL *A,int n);
int buscar_dato(ARBOL A,int n);
void menu_principal();
void ventana_explicacion();
void postorden(ARBOL A);
int nivel_superado(ARBOL A,int nivel,int d);
int posicion_cursor(int xi,int xf,int yi,int yf,int mousex,int mousey);
int mini_ventana(char *ptr,int n);
void print_on_screen(char *c,int x,int y,SDL_Color color,TTF_Font *fonti);
void print_arbol(ARBOL A,int n);
void ventana_recorridos();
void preorden(ARBOL A);
void insertar_arbol(ARBOL *A,int dato);
void inorden(ARBOL A);

int main(int argc, char *argv[])
{	//inicializando SDL
        if(SDL_Init(SDL_INIT_VIDEO)<0)
        {       printf("Error al establecer modo video\n");exit(1);}
        SDL_WM_SetCaption("Prueba_botones",NULL);
        screen=SDL_SetVideoMode(ancho,alto,24,SDL_SWSURFACE);
        if(screen==NULL)
        {       printf("No se establecio el modo de video\n");
                exit(1);
        }
	//font
	TTF_Init();
	font_num=TTF_OpenFont("fonts/quid.ttf",60);
	if(font_num==NULL)
		printf("Error al cargar font\n");
	font_menu=TTF_OpenFont("fonts/font_menu.ttf",80);
	if(font_menu==NULL)
		printf("Error al cargar font_menu\n");
	font=TTF_OpenFont("fonts/FUAA.ttf",34);
	if(font==NULL)
		printf("Error en font\n");
	font_op=TTF_OpenFont("fonts/FUAA.ttf",20);
	arbol_ttf=TTF_OpenFont("fonts/arbol.ttf",25);
	if(arbol_ttf==NULL)
		printf("Error al cargar arbol\n");
	recorrido_ttf=TTF_OpenFont("fonts/arbol.ttf",17);
	fcolor.r=0; fcolor.g=0; fcolor.b=0;
	
	//principal
	A=NULL;
	int opcion=-1,n,dato;
	SDL_Rect pos;
	cargando_interface();
	menu_principal();
	draw_interface_principal();
	SDL_Event evento;
	while(opcion!=0)
	{	SDL_WaitEvent(&evento);
		if(evento.type==SDL_MOUSEMOTION)
		{	if(posicion_cursor(20,85,12,35,evento.motion.x,evento.motion.y))
			{	pos.x=20; pos.y=12;
				SDL_BlitSurface(boton_insertar[1],NULL,screen,&pos);
			}
			else if(posicion_cursor(145,210,12,35,evento.motion.x,evento.motion.y))
                        {       pos.x=145; pos.y=12;
                                SDL_BlitSurface(boton_eliminar[1],NULL,screen,&pos);
                        }
			else if(posicion_cursor(270,335,12,35,evento.motion.x,evento.motion.y))
                        {       pos.x=270; pos.y=12;
                                SDL_BlitSurface(boton_recorridos[1],NULL,screen,&pos);
                        }
			else if(posicion_cursor(820,885,12,35,evento.motion.x,evento.motion.y))
                        {       pos.x=820; pos.y=12;
                                SDL_BlitSurface(boton_salir[1],NULL,screen,&pos);
                        }
			else
				draw_menu_botones();
			SDL_Flip(screen);		
		}
		else if(evento.type==SDL_MOUSEBUTTONDOWN)
		{	if(posicion_cursor(820,885,12,35,evento.button.x,evento.button.y))
                        {
				menu_principal();
			}
			else if(posicion_cursor(20,85,12,35,evento.button.x,evento.button.y))
			{	dato=mini_ventana("Insertar dato: ",1);
				if(bandera!=0 && nivel_superado(A,0,dato))
					ventana_alerta("La rama supero el maximo");
				else
				{	if(bandera!=0)
						insertar_arbol(&A,dato);
					calcular_posiciones(A,70,450,450,0);
				}
				print_arbol(A,0);
				SDL_Flip(screen);
			}
			else if(posicion_cursor(145,210,12,35,evento.button.x,evento.button.y))
			{	dato=mini_ventana("Eliminar dato: ",2);
				eliminar(&A,dato);
				draw_interface_principal();
				calcular_posiciones(A,70,450,450,0);
				print_arbol(A,0);
				SDL_Flip(screen);
				
			}
			else if(posicion_cursor(270,335,12,35,evento.button.x,evento.button.y))
			{	ventana_recorridos();
			}
	
		}
		else if(evento.type==SDL_KEYDOWN)
                {       switch(evento.key.keysym.sym)
                        {       case SDLK_1:
				{ 	dato=mini_ventana("Insertar dato: ",1);
                               		if(bandera!=0 && nivel_superado(A,0,dato))
                                		ventana_alerta("La rama supero el maximo");	
					else
	                                {       if(bandera!=0)
        	                                        insertar_arbol(&A,dato);
                	                        calcular_posiciones(A,70,450,450,0);
                        	        }
                                	print_arbol(A,0);
                               		SDL_Flip(screen);
					break;
				}
				case SDLK_2:
				{	dato=mini_ventana("Eliminar dato: ",2);
  	         	                eliminar(&A,dato);
        	                        draw_interface_principal();
                	                calcular_posiciones(A,70,450,450,0);
                        	        print_arbol(A,0);
                                        SDL_Flip(screen);
       		                        break;
				}
				case SDLK_4:
				{	menu_principal();
					break;
				}
				case SDLK_3:
				{	ventana_recorridos();
					break;
				}
				
			}
		}
	}
	SDL_Quit();
	return 0;

}
int buscar_dato(ARBOL A,int n)
{	if(A==NULL)
                return 0;
        if(n==A->dato)
                return 1;
        if(n>A->dato)
                return buscar_dato(A->der,n);
        return buscar_dato(A->izq,n);
}
int mayor(ARBOL A)
{       if(A==NULL)
                return -1;
        if(A->der==NULL)
                return A->dato;
        return mayor(A->der);
}
void eliminar(ARBOL *A,int n)
{	if(*A==NULL)
                return;
        if(n<(*A)->dato)
                eliminar(&((*A)->izq),n);
        else if(n>(*A)->dato)
                eliminar(&((*A)->der),n);
        else
        {       if((*A)->izq==NULL && (*A)->der==NULL)
                {       free(*A);
                        *A=NULL;
                }
                else if((*A)->izq==NULL)
                {       ARBOL aux=*A;
                        *A=(*A)->der;
                        free(aux);
                }
                else if((*A)->der==NULL)
                {       ARBOL aux=*A;
                        *A=(*A)->izq;
                        free(aux);
                }
                else
                {       (*A)->dato=mayor((*A)->izq);
                        eliminar(&((*A)->izq),(*A)->dato);
                }
        }       
}	
void ventana_recorridos()
{	SDL_Rect pos;
	char c[40];
	pos.x=300; pos.y=251;
	SDL_BlitSurface(mini_window,NULL,screen,&pos);
	sprintf(c,"Recorridos :");
	print_on_screen(&c[0],370,260,fcolor,font);
	pos.x+=110;pos.y+=50;
	SDL_BlitSurface(tipos_recorridos[0][0],NULL,screen,&pos);
	pos.y+=30;
	SDL_BlitSurface(tipos_recorridos[1][0],NULL,screen,&pos);
	pos.y+=30;
	SDL_BlitSurface(tipos_recorridos[2][0],NULL,screen,&pos);
	pos.x+=119;pos.y+=34;
	SDL_BlitSurface(boton_cancelar[0],NULL,screen,&pos);
	SDL_Flip(screen);
	int n=1;
	SDL_Event evento;
	while(n)
	{	SDL_WaitEvent(&evento);
                if(evento.type==SDL_MOUSEMOTION)
		{	if(posicion_cursor(410,410+tipos_recorridos[0][0]->w,301,301+tipos_recorridos[0][0]->h,evento.motion.x,evento.motion.y))
			{	pos.x=410; pos.y=301;
				SDL_BlitSurface(tipos_recorridos[0][1],NULL,screen,&pos);
			}
			else if(posicion_cursor(410,410+tipos_recorridos[1][0]->w,331,331+tipos_recorridos[1][0]->h,evento.motion.x,evento.motion.y))
			{	pos.x=410; pos.y=331,
				SDL_BlitSurface(tipos_recorridos[1][1],NULL,screen,&pos);
			}
			else if(posicion_cursor(410,410+tipos_recorridos[1][0]->w,361,361+tipos_recorridos[1][0]->h,evento.motion.x,evento.motion.y))
			{	pos.x=410; pos.y=361;
				SDL_BlitSurface(tipos_recorridos[2][1],NULL,screen,&pos);
			}
			else if(posicion_cursor(529,529+boton_cancelar[0]->w,395,395+boton_cancelar[0]->h,evento.motion.x,evento.motion.y))
			{	pos.x=529; pos.y=395;
				SDL_BlitSurface(boton_cancelar[1],NULL,screen,&pos);
			}
			else
			{	pos.x=410; pos.y=301;
                                SDL_BlitSurface(tipos_recorridos[0][0],NULL,screen,&pos);
				pos.x=410; pos.y=331,
                                SDL_BlitSurface(tipos_recorridos[1][0],NULL,screen,&pos);
				pos.x=410; pos.y=361;
                                SDL_BlitSurface(tipos_recorridos[2][0],NULL,screen,&pos);
				pos.x=529; pos.y=395;
                                SDL_BlitSurface(boton_cancelar[0],NULL,screen,&pos);

			}
			SDL_Flip(screen);
		}
		else if(evento.type==SDL_MOUSEBUTTONDOWN)
                {       if(posicion_cursor(410,410+tipos_recorridos[0][0]->w,301,301+tipos_recorridos[0][0]->h,evento.button.x,evento.button.y))
                        {	draw_interface_principal();
                                print_arbol(A,0);
				SDL_Rect recta_pos={0,600,900,80};
				SDL_FillRect(screen,&recta_pos,SDL_MapRGBA(screen->format,183,181,182,0));				
				char c[40];
				sprintf(c,"Recorrido Inorder :");
				print_on_screen(&c[0],30,600,fcolor,font_op);distancia=0;
				SDL_Flip(screen);
				inorden(A);
				return;
			}
			else if(posicion_cursor(410,410+tipos_recorridos[1][0]->w,331,331+tipos_recorridos[1][0]->h,evento.button.x,evento.button.y))
			{	draw_interface_principal();
                                print_arbol(A,0);
                                SDL_Rect recta_pos={0,600,900,80};
                                SDL_FillRect(screen,&recta_pos,SDL_MapRGBA(screen->format,183,181,182,0));
                                char c[40];
                                sprintf(c,"Recorrido Preorder :");
                                print_on_screen(&c[0],30,600,fcolor,font_op);distancia=0;
                                SDL_Flip(screen);
				preorden(A);
                                return;
			}
			else if(posicion_cursor(410,410+tipos_recorridos[1][0]->w,361,361+tipos_recorridos[1][0]->h,evento.button.x,evento.button.y))
			{	draw_interface_principal();
                                print_arbol(A,0);
                                SDL_Rect recta_pos={0,600,900,80};
                                SDL_FillRect(screen,&recta_pos,SDL_MapRGBA(screen->format,183,181,182,0));
                                char c[40];
                                sprintf(c,"Recorrido Posorder :");
                                print_on_screen(&c[0],30,600,fcolor,font_op);distancia=0;
                                SDL_Flip(screen);
				postorden(A);
                                return;
			}
			else if(posicion_cursor(529,529+boton_cancelar[0]->w,395,395+boton_cancelar[0]->h,evento.button.x,evento.button.y))
			{	draw_interface_principal();
                                print_arbol(A,0);
                                SDL_Flip(screen);
                                return;
			}
		}
		else if(evento.type==SDL_KEYDOWN && evento.key.keysym.sym==27)
                {       draw_interface_principal();
                        draw_menu_botones();
			print_arbol(A,0);
			SDL_Flip(screen);
			return;
		}
	}
	SDL_Flip(screen);
}
int nivel_superado(ARBOL A,int nivel,int d)
{	if(A==NULL)
	{	if(nivel>=5)
			return 1;
		else
			return 0;
	}
	if(d>A->dato)
		return nivel_superado(A->der,nivel+1,d);
	else
		return nivel_superado(A->izq,nivel+1,d);
}
	
void menu_principal()
{       SDL_Rect pos;
        pos.x=0; pos.y=0;
        SDL_BlitSurface(img_principal,NULL,screen,&pos);
        SDL_Flip(screen);
        SDL_Event evento;
        int i=0;
        while(1)
        {       SDL_WaitEvent(&evento);
                if(evento.type==SDL_MOUSEBUTTONDOWN)
                {       if(posicion_cursor(200,680,90,190,evento.button.x,evento.button.y))
                        {       SDL_BlitSurface(fondo,NULL,screen,&pos);
				draw_interface_principal();
				calcular_posiciones(A,70,450,450,0);
				print_arbol(A,0);
				SDL_Flip(screen); 
				return;
			}
                        else if(posicion_cursor(200,680,200,290,evento.button.x,evento.button.y))
                        {       ventana_explicacion();
				return;
			}
                        else if(posicion_cursor(200,680,300,390,evento.button.x,evento.button.y))
                     	{	ventana_ayuda();
				return;
			}
                        else if(posicion_cursor(200,680,400,490,evento.button.x,evento.button.y))
                        {	ventana_acerca();
				return;
			}
                        else if(posicion_cursor(200,680,500,590,evento.button.x,evento.button.y))
                        {       SDL_Quit();
                                exit(0);
                        }


                }
        }
}
void print_arbol(ARBOL A,int n)
{	if(A==NULL)
		return;	
	if(A->der!=NULL)
	{	SDL_Rect posi;
		posi.y=(A->pos).y+10;
        	posi.x=(A->pos).x+20;
                SDL_BlitSurface(flechader[n],NULL,screen,&posi);
	}
	if(A->izq!=NULL)
	{	SDL_Rect posi;
		posi.y=(A->pos).y+10;
        	posi.x=(A->pos).x-((flechaizq[n]->w-20));
                SDL_BlitSurface(flechaizq[n],NULL,screen,&posi);
	}
	SDL_BlitSurface(nodo_img,NULL,screen,&(A->pos));
	char c[5];
	sprintf(c,"%d",A->dato);
	print_on_screen(&c[0],A->pos.x+6,A->pos.y+6,fcolor,arbol_ttf);
	//SDL_Flip(screen);
	print_arbol(A->izq,n+1);
	print_arbol(A->der,n+1);
}

void ventana_alerta(char *ptr)
{	SDL_Rect pos;
	pos.x=200;pos.y=230;
	SDL_BlitSurface(window_alerta,NULL,screen,&pos);
	print_on_screen(ptr,280,260,fcolor,font);
	pos.x=440;pos.y=340;
	SDL_BlitSurface(boton_ok[0],NULL,screen,&pos);
	SDL_Flip(screen);
	SDL_Event evento;
	while(1)
	{	SDL_WaitEvent(&evento);
                if(evento.type==SDL_MOUSEMOTION)
                {	if(posicion_cursor(440,505,340,363,evento.motion.x,evento.motion.y))
				SDL_BlitSurface(boton_ok[1],NULL,screen,&pos);
			else
			        SDL_BlitSurface(boton_ok[0],NULL,screen,&pos);
			SDL_Flip(screen);
		}
		else if(evento.type==SDL_MOUSEBUTTONDOWN)
		{	if(posicion_cursor(440,505,340,363,evento.button.x,evento.button.y))
			{	draw_interface_principal();
                                print_arbol(A,0);
                                SDL_Flip(screen);
				return;
			}
		}
		if(evento.type==SDL_KEYDOWN && evento.key.keysym.sym==27)
                {       draw_interface_principal();
                        draw_menu_botones();
			SDL_Flip(screen);
                        return;
                }
	} 
	
}
void insertar_arbol(ARBOL *A,int dato)
{	if(*A==NULL)
	{	*A=(PNODO)malloc(sizeof(NODO));
		if(*A==NULL)
		{	ventana_alerta("Error,no hay sufuciente memoria");return;}
		(*A)->dato=dato;
		(*A)->izq=(*A)->der=NULL;
		
	}
	if((*A)->dato<dato)
		insertar_arbol(&((*A)->der),dato);
	else if((*A)->dato>dato)
		insertar_arbol(&((*A)->izq),dato);
}
void calcular_posiciones(ARBOL A,int y, int x,int n,int op)
{	if(A==NULL)
		return;
	if(op==0)
	{	(A->pos).x=x-22;
		(A->pos).y=y-20;
	}
	else if(op==1)
		(A->pos).x=x;
	else if(op==2)
		(A->pos).x=x;
	(A->pos).y=y;
	calcular_posiciones(A->izq,y+120,(A->pos).x-(n/2),n/2,1);
	calcular_posiciones(A->der,y+120,(A->pos).x+(n/2),n/2,2);		
}
int posicion_cursor(int xi,int xf,int yi,int yf,int mousex,int mousey)
{	if(mousex>=xi && mousex<=xf && mousey>=yi && mousey<=yf)
		return 1;
	return 0;
}
int mini_ventana(char *ptr,int n)
{	SDL_Rect pos;
	pos.x=300;pos.y=251;
        SDL_BlitSurface(mini_window,NULL,screen,&pos);
	pos.x=390; pos.y=310;
	SDL_BlitSurface(texto,NULL,screen,&pos);
	pos.x=325; pos.y=385;
	SDL_BlitSurface(boton_aceptar[0],NULL,screen,&pos);
	pos.x+=185;
	SDL_BlitSurface(boton_cancelar[0],NULL,screen,&pos);
	if(n==1)
        {       pos.x=320; pos.y=270;
                SDL_BlitSurface(icon_add,NULL,screen,&pos);
        }
	else if(n==2)
	{	pos.x=320; pos.y=270;
                SDL_BlitSurface(icon_del,NULL,screen,&pos);
	}
	print_on_screen(ptr,370,260,fcolor,font);
	SDL_Flip(screen);		
	int opcion=-1,aux=1,k=0;
	char c[4];
	SDL_Rect text_pos;
	SDL_Event evento;
	while(opcion!=0)
	{	SDL_WaitEvent(&evento);
		if(evento.type==SDL_MOUSEMOTION)
                {       if(posicion_cursor(325,390,385,408,evento.motion.x,evento.motion.y))
                        {       pos.x=325; pos.y=385;
                                SDL_BlitSurface(boton_aceptar[1],NULL,screen,&pos);
                        }
			else if(posicion_cursor(510,580,385,408,evento.motion.x,evento.motion.y))
			{	 pos.x=510;pos.y=385;
                                 SDL_BlitSurface(boton_cancelar[1],NULL,screen,&pos);
			}
			else
			{	pos.x=325; pos.y=385;
        			SDL_BlitSurface(boton_aceptar[0],NULL,screen,&pos);
        			pos.x+=185;
       				 SDL_BlitSurface(boton_cancelar[0],NULL,screen,&pos);
			}
			SDL_Flip(screen);
		}
		else if(evento.type==SDL_MOUSEBUTTONDOWN)
                {       if(posicion_cursor(510,580,385,408,evento.button.x,evento.button.y))
                        {	draw_interface_principal();
        			draw_menu_botones();
				bandera=0;
        			return -1;
			}
			else if(posicion_cursor(325,390,385,408,evento.motion.x,evento.motion.y))
			{	draw_interface_principal();
        			draw_menu_botones();
				bandera=1;
				return k*aux;  
			}      
		}
		else if(evento.type==SDL_KEYDOWN && k<10)
                {       switch(evento.key.keysym.sym)
                        {       case SDLK_MINUS:
				{	aux=-1; break;}
				case SDLK_1:
				{ 	k*=10; k+=1;break;}
				case SDLK_2:
				{	k*=10;k+=2; break;}	
				case SDLK_3:
				{	k*=10; k+=3; break;}
				case SDLK_4:
                                {       k*=10; k+=4; break;}
				case SDLK_5:
                                {      k*=10; k+=5; break;}
				case SDLK_6:
                                {       k*=10; k+=6; break;}
				case SDLK_7:
                                {       k*=10; k+=7; break;}
				case SDLK_8:
                                {       k*=10; k+=8; break;}
				case SDLK_9:
                                {       k*=10; k+=9; break;}
				case SDLK_0:
				{	k*=10; break;}
				
			}				
		}
		if(evento.type==SDL_KEYDOWN && evento.key.keysym.sym==8)
			k/=10;
		else if(evento.type==SDL_KEYDOWN && evento.key.keysym.sym==SDLK_RETURN)
		{	draw_interface_principal();
                        draw_menu_botones();
                        bandera=1;
                        return k*aux;
		}
		else if(evento.type==SDL_KEYDOWN && evento.key.keysym.sym==27)
		{	draw_interface_principal();
                        draw_menu_botones();
                        bandera=0;
                        return -1;
		}
		text_pos.x=390; text_pos.y=310;
       		SDL_BlitSurface(texto,NULL,screen,&text_pos);
		sprintf(c,"%d",k*aux);
		print_on_screen(&c[0],410,310,fcolor,font_num);		
		SDL_Flip(screen);
	}
}
void draw_interface_principal()
{	SDL_Rect pos;
	pos.x=0; pos.y=0;SDL_BlitSurface(fondo,NULL,screen,&pos);
	draw_menu_botones();
	SDL_Flip(screen);
}
void draw_menu_botones()
{	SDL_Rect pos,posi;
	char c[4];
	pos.x=20; pos.y=12;SDL_BlitSurface(boton_insertar[0],NULL,screen,&pos);
	posi.x=pos.x+boton_insertar[0]->w+2;sprintf(c,"[1]");
	posi.y=2;
	print_on_screen(&c[0],posi.x,posi.y+10,fcolor,font_op);

        pos.x+=125;SDL_BlitSurface(boton_eliminar[0],NULL,screen,&pos);
        posi.x=pos.x+boton_insertar[0]->w+2;sprintf(c,"[2]");
        print_on_screen(&c[0],posi.x,posi.y+10,fcolor,font_op);

	pos.x+=125; SDL_BlitSurface(boton_recorridos[0],NULL,screen,&pos);
	posi.x=pos.x+boton_insertar[0]->w+2;sprintf(c,"[3]");
        print_on_screen(&c[0],posi.x,posi.y+10,fcolor,font_op);

	pos.x+=550; SDL_BlitSurface(boton_salir[0],NULL,screen,&pos);
	posi.x=pos.x+boton_insertar[0]->w+2;sprintf(c,"[4]");
        print_on_screen(&c[0],posi.x,posi.y+10,fcolor,font_op);

}
void cargando_interface()
{	int i;
	char c[100];
	for(i=0; i<4; i++)
	{	sprintf(c,"imagenes/flechader%d.png",i);
		Load_image(&flechader[i],&c[0]);
		sprintf(c,"imagenes/flechaizq%d.png",i);
		Load_image(&flechaizq[i],&c[0]);
	}
	for(i=0; i<2; i++)
	{	sprintf(c,"imagenes/botones/inorder%d.png",i);
		Load_image(&tipos_recorridos[0][i],&c[0]);
		sprintf(c,"imagenes/botones/preorder%d.png",i);
		Load_image(&tipos_recorridos[1][i],&c[0]);
		sprintf(c,"imagenes/botones/posorder%d.png",i);
		Load_image(&tipos_recorridos[2][i],&c[0]);	
	}
	Load_image(&window_alerta,"imagenes/alerta.png");
	Load_image(&window_acerca,"imagenes/acercade.png");
	Load_image(&window_ayuda,"imagenes/ayuda.png");
	Load_image(&window_explicacion,"imagenes/explicacion.png");
	Load_image(&fondo,"imagenes/interface1.png");
	Load_image(&img_principal,"imagenes/interface.png");
     	Load_image(&m_principal,"imagenes/interface.png");
	Load_image(&icon_add,"imagenes/add.png");
	Load_image(&nodo_img,"imagenes/dibujo.png");
	Load_image(&texto,"imagenes/texto.jpg");
	Load_image(&icon_del,"imagenes/del.png");
	Load_image(&mini_window,"imagenes/mini_windows.png");
	Load_image(&boton_aceptar[0],"imagenes/botones/aceptar0.png");
	Load_image(&boton_aceptar[1],"imagenes/botones/aceptar1.png");
	Load_image(&boton_cancelar[0],"imagenes/botones/cancelar0.png");
	Load_image(&boton_cancelar[1],"imagenes/botones/cancelar1.png");
	Load_image(&boton_eliminar[0],"imagenes/botones/eliminar0.png");
	Load_image(&nodo_visitado,"imagenes/nodo_visitado.png");
	Load_image(&boton_eliminar[1],"imagenes/botones/eliminar1.png");
	Load_image(&boton_ino[0],"imagenes/botones/inorder0.png");
	Load_image(&boton_ino[1],"imagenes/botones/inorder1.png");
	Load_image(&boton_insertar[0],"imagenes/botones/insertar0.png");
	Load_image(&boton_insertar[1],"imagenes/botones/insertar1.png");
	Load_image(&boton_ok[0],"imagenes/botones/ok0.png");
	Load_image(&boton_pos[0],"imagenes/botones/posorder0.png");
	Load_image(&boton_pos[1],"imagenes/botones/posorder1.png");
	Load_image(&boton_pre[0],"imagenes/botones/preorder0.png");
	Load_image(&boton_pre[1],"imagenes/botones/preorder1.png");
	Load_image(&boton_recorridos[0],"imagenes/botones/recorrido0.png");
	Load_image(&boton_recorridos[1],"imagenes/botones/recorrido1.png");
	Load_image(&boton_salir[0],"imagenes/botones/salir0.png");
	Load_image(&boton_salir[1],"imagenes/botones/salir1.png");		
}
void ventana_explicacion()
{	SDL_Rect pos;
	pos.x=0;pos.y=0;
	SDL_BlitSurface(window_explicacion,NULL,screen,&pos);
	pos.x=430; pos.y=640;
	SDL_BlitSurface(boton_salir[0],NULL,screen,&pos);
	SDL_Flip(screen);
	SDL_Event eventito;
	while(1)
        {       SDL_WaitEvent(&eventito);
                if(eventito.type==SDL_MOUSEMOTION)
                {       if(posicion_cursor(430,495,640,663,eventito.motion.x,eventito.motion.y))
                        {	pos.x=430; pos.y=640;
        			SDL_BlitSurface(boton_salir[1],NULL,screen,&pos);
			}
			else
			{	pos.x=430; pos.y=640;
        			SDL_BlitSurface(boton_salir[0],NULL,screen,&pos);
			}
			SDL_Flip(screen);	
		}
		 else if(eventito.type==SDL_MOUSEBUTTONDOWN)
                {       if(posicion_cursor(430,495,640,663,eventito.button.x,eventito.button.y))
                        { 	menu_principal();
				return;
			}
		}
		else if(eventito.type==SDL_KEYDOWN && eventito.key.keysym.sym==SDLK_RETURN || eventito.key.keysym.sym==27)
		{	menu_principal();
                        return;
		}
	}
}
void ventana_acerca()
{       SDL_Rect pos;
        pos.x=0;pos.y=0;
        SDL_BlitSurface(window_acerca,NULL,screen,&pos);
        pos.x=430; pos.y=640;
        SDL_BlitSurface(boton_salir[0],NULL,screen,&pos);
        SDL_Flip(screen);
        SDL_Event eventito;
        while(1)
        {       SDL_WaitEvent(&eventito);
                if(eventito.type==SDL_MOUSEMOTION)
                {       if(posicion_cursor(430,495,640,663,eventito.motion.x,eventito.motion.y))
                        {       pos.x=430; pos.y=640;
                                SDL_BlitSurface(boton_salir[1],NULL,screen,&pos);
                        }
                        else
                        {       pos.x=430; pos.y=640;
                                SDL_BlitSurface(boton_salir[0],NULL,screen,&pos);
                        }
                        SDL_Flip(screen);
                }
                 else if(eventito.type==SDL_MOUSEBUTTONDOWN)
                {       if(posicion_cursor(430,495,640,663,eventito.button.x,eventito.button.y))
                        {       menu_principal();
                                return;
                        }
                }
                else if(eventito.type==SDL_KEYDOWN && eventito.key.keysym.sym==SDLK_RETURN || eventito.key.keysym.sym==27)
                {       menu_principal();
                        return;
                }
        }
}

void ventana_ayuda()
{       SDL_Rect pos;
        pos.x=0;pos.y=0;
        SDL_BlitSurface(window_ayuda,NULL,screen,&pos);
        pos.x=430; pos.y=640;
        SDL_BlitSurface(boton_salir[0],NULL,screen,&pos);
        SDL_Flip(screen);
        SDL_Event eventito;
        while(1)
        {       SDL_WaitEvent(&eventito);
                if(eventito.type==SDL_MOUSEMOTION)
                {       if(posicion_cursor(430,495,640,663,eventito.motion.x,eventito.motion.y))
                        {       pos.x=430; pos.y=640;
                                SDL_BlitSurface(boton_salir[1],NULL,screen,&pos);
                        }
                        else
                        {       pos.x=430; pos.y=640;
                                SDL_BlitSurface(boton_salir[0],NULL,screen,&pos);
                        }
                        SDL_Flip(screen);
                }
                 else if(eventito.type==SDL_MOUSEBUTTONDOWN)
                {       if(posicion_cursor(430,495,640,663,eventito.button.x,eventito.button.y))
                        {       menu_principal();
                                return;
                        }
                }
                else if(eventito.type==SDL_KEYDOWN && eventito.key.keysym.sym==SDLK_RETURN || eventito.key.keysym.sym==27)
                {       menu_principal();
                        return;
                }
        }
}

void Load_image(SDL_Surface **image,char *ptr)
{       *image=IMG_Load(ptr);
        if(*image==NULL)
               printf("Error no se cargo %s\n ",ptr);
       
}
void print_on_screen(char *c,int x,int y,SDL_Color color,TTF_Font *fonti)
{       SDL_Rect pos;
        pos.x=x; pos.y=y;
        SDL_Surface *letras;
        letras=TTF_RenderText_Solid(fonti,c,color);
        SDL_BlitSurface(letras,NULL,screen,&pos);
}
void preorden(ARBOL A)
{       if(A==NULL)
                return;
       	char c[5];
	SDL_BlitSurface(nodo_visitado,NULL,screen,&(A->pos));
        sprintf(c,"%d ",A->dato);
        print_on_screen(&c[0],A->pos.x+6,A->pos.y+6,fcolor,arbol_ttf);
        SDL_Flip(screen);
        SDL_Delay(1500);
        SDL_BlitSurface(nodo_img,NULL,screen,&(A->pos));
        sprintf(c,"%d ",A->dato);
        print_on_screen(&c[0],A->pos.x+6,A->pos.y+6,fcolor,arbol_ttf);
        imprimir_recorridos(A->dato);

        preorden(A->izq);
        preorden(A->der);
}

void inorden(ARBOL A)
{       if(A==NULL)
                return;
	char c[5];
        inorden(A->izq);
	
	SDL_BlitSurface(nodo_visitado,NULL,screen,&(A->pos));
	sprintf(c,"%d ",A->dato);
        print_on_screen(&c[0],A->pos.x+6,A->pos.y+6,fcolor,arbol_ttf);
	SDL_Flip(screen);
	SDL_Delay(1500);
	SDL_BlitSurface(nodo_img,NULL,screen,&(A->pos));
        sprintf(c,"%d ",A->dato);
        print_on_screen(&c[0],A->pos.x+6,A->pos.y+6,fcolor,arbol_ttf);
	imprimir_recorridos(A->dato);	
	SDL_Flip(screen);
	inorden(A->der);
}
void postorden(ARBOL A)
{       if(A==NULL)
                return;
        postorden(A->izq);
        postorden(A->der);
	char c[5];
	SDL_BlitSurface(nodo_visitado,NULL,screen,&(A->pos));
        sprintf(c,"%d ",A->dato);
        print_on_screen(&c[0],A->pos.x+6,A->pos.y+6,fcolor,arbol_ttf);
        SDL_Flip(screen);
        SDL_Delay(1500);
        SDL_BlitSurface(nodo_img,NULL,screen,&(A->pos));
        sprintf(c,"%d ",A->dato);
        print_on_screen(&c[0],A->pos.x+6,A->pos.y+6,fcolor,arbol_ttf);
        imprimir_recorridos(A->dato);
        SDL_Flip(screen);       
}

void imprimir_recorridos(int n)
{	char c[5];
	sprintf(c,"%d",n);
	print_on_screen(&c[0],distancia,630,fcolor,recorrido_ttf);
	distancia+=30;
	SDL_Flip(screen);
}
