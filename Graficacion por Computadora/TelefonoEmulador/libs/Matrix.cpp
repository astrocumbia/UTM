#ifndef _MATRIX_CPP_
#define _MATRIX_CPP_

#include "Matrix.h"


Matrix::Matrix( ){
	identity( );
}

void Matrix::identity( ){
	for( int i=0; i<3; i++ )
		for( int j=0; j<3; j++ )
			m[i][j] = i==j? 1.0:0.0;
}

void Matrix::print( ){
	for( int i=0; i<3; i++ ){
		for( int j=0; j<3; j++ )
			std::cout<<m[i][j]<<" ";
		std::cout<<"\n";
	}
}

void Matrix::println( ){
	print( );
	std::cout<<"\n";
}

void Matrix::setIndexOf( int i, int j, double value ){
	if( i<0 || j<0 || i>=3 || j>=3 )
		return;
	m[i][j] = value;
}

void Matrix::setIndexOf( int i, int j, int value ){
	if( i<0 || j<0 || i>=3 || j>=3 )
		return;
	m[i][j] = (double)value;
}

double Matrix::getIndexOf( int i, int j ){
	if( i<0 || j<0 || i>=3 || j>=3 )
		return 0;
	return m[i][j];
}

void Matrix::copy( double a[3][3] ){
	for( int i=0; i<3; i++ )
		for( int j=0; j<3; j++ )
			m[i][j] = a[i][j];
}

void Matrix::multiply( double a[3][3] ){
	double tmp[3][3] = {{0,0,0}};
	for( int i=0; i<3; i++ )
		for( int j=0; j<3; j++ )
			for( int k=0; k<3; k++ )
				tmp[i][j]+=(m[i][k]*a[k][j]);
	copy( tmp );
}

void Matrix::displace( double x, double y ){
	double tmp[3][3]={{1,0,0},
					  {0,1,0},
					  {0,0,1}};
	tmp[0][2] = x;
	tmp[1][2] = y;
	multiply( tmp );
}

void Matrix::rotate( double teta ){
	double tmp[3][3]={{1,0,0},
					  {0,1,0},
					  {0,0,1}};

	tmp[0][0] = cos( (teta*_PI)/180 );
	tmp[1][0] = sin( (teta*_PI)/180 );
	tmp[0][1] = -sin( (teta*_PI)/180 );
	tmp[1][1] = cos( (teta*_PI)/180 );  

	multiply( tmp );  
}

void Matrix::scale( double sx, double sy ){
	double tmp[3][3]={{1,0,0},
					  {0,1,0},
					  {0,0,1}};
	tmp[0][0] = sx;
	tmp[1][1] = sy;
	multiply( tmp );	
}
#endif