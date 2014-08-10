<?php

namespace NlpTools\Tokenizers;

/**
 * White space phrase tokenizer.
 * Break on every white space
 * Create ngrams with the specified number of words ( $n )
 */
class WhitespaceNgramTokenizer implements TokenizerInterface
{

    private $n=1; // phrase word length
    
    const PATTERN = '/[\pZ\pC]+/u';

    public function set_n( $n ) {
      $this->n = $n;
    }

    public function tokenize( $str )
    {
    
        // generate unigrams
        $unigrams = preg_split(self::PATTERN,$str,null,PREG_SPLIT_NO_EMPTY);
        $num_unigrams = count( $unigrams );
        
        // generate other nGrams
        $ngrams = array();
        for( $n=2; $n<=$this->n; $n++ ) {
          // loop through each unigram location in the text
          for( $i=0; $i<=$num_unigrams-$n; $i++ ) {
            $key = $i;
            $ngram = array();
            for( $key=$i; $key<$i+$n; $key++ )
              $ngram[] = $unigrams[$key];
            $ngrams[] = implode( ' ', $ngram );
          }
        }
        
        // combine unigrams with new ngrams
        $ngrams = array_merge( $unigrams, $ngrams );
        
        return $ngrams;
        
    }
}
